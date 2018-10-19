<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Services\Impl\IGroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Group;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IUserService;
use App\Services\Criteria\User\WithSupervisors;
use App\Services\Criteria\User\WhereRole;
use App\Services\Criteria\User\WhereTherapist;

/**
 * Manages administrative actions against group.
 */
class GroupController extends Controller
{
	/**
     * The service implementation for group.
     *
     * @var IGroupService
     */
    protected $group,$user;
	
    /**
     * Creates an instance of `GroupController`.
     *
     * @param IGroupService $service
     */
    public function __construct(IGroupService $group,IUserService $user)
    {
        $this->group = $group;
		$this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $groups = $this->group->paginate();

        return view('admin.groups.index')->with([
            'groups' => $groups,
        ]);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return Response
     */
    public function search(Request $request)
    {
        if (! $request->search) {
            return redirect('admin/groups');
        }

        $groups = $this->group->search($request->search);

        return view('admin.groups.index')->with([
            'groups' => $groups,
        ]);
    }
	
    /**
     * Show the form for creating a group.
     *
     * @return Response
     */
    public function create()
    {
		$therapists = $this->user
            ->pushCriteria(new WhereTherapist())
            ->pushCriteria(new WithRole())
            ->all();
        return view('admin.groups.create')->with([
            'therapists' => $therapists,
        ]);
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return Response
     */
    public function store(GroupCreateRequest $request)
    {
		$r = $this->group->create($request->except(['_token', '_method']));
		foreach($request->therapist_id as $userid){
			$user = User::find($userid);
			$user->groups()->attach($r->id);
		}
        return redirect('admin/groups')->with([
            'message' => __('admin.groups.index.created-group'),
        ]);
    }
	
	/**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return Response
     */
    public function edit(string $id)
    {
        $group = Group::find($id);
		$users_id = $group->users()->pluck('user_id');
		
		$therapists = $this->user
            ->pushCriteria(new WhereTherapist())
            ->pushCriteria(new WithRole())
            ->all();
			
        if (is_null($group)) {
            abort(404);
        }

        return view('admin.groups.edit')->with([
            'group' => $group,
			'therapists' => $therapists,
			'users_id' => $users_id,
        ]);
    }
		
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return Response
     */
    public function update(Request $request, string $id)
    {
		$group = Group::find($id);
		
        if (is_null($group)) {
            abort(404);
        }

        $this->group->update(
            $group->id,
            $request->except(['_token', '_method'])
        );
		$users = $group->users()->get();
		foreach($users as $user){
			$group->users()->detach($user->user_id);
		}
		
		foreach($request->therapist_id as $userid){
			$user = User::find($userid);
			$user->groups()->attach($id);
		}
		
        return back()->with([
            'message' => __('admin.groups.index.updated-group'),
        ]);
    }
	
	/**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id)
    {
        $group = $this->group->findBy('id', $id);

        if (is_null($group)) {
            abort(404);
        }
		User::where('group_id',$id)->update(['group_id' => null]);
        $this->group->delete($group->id);

        return redirect('admin/groups')->with([
            'message' => __('admin.groups.index.deleted-group'),
        ]);
    }
}
