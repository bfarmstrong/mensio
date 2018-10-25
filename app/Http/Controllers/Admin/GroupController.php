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

    public function index(Request $request)
    {
        $groups = $this->group->paginate();
		if ($request->user_id) {
			$all_groups = $groups;
			$user = User::find($request->user_id);
			$groups = $user->groups()->paginate();
			return view('admin.users.groups.index')->with([
				'groups' => $groups,
				'user' => $user,
				'all_groups' => $all_groups
				]);	
		} else {
			return view('admin.groups.index')->with([
				'groups' => $groups,
			]);
		}

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
	if ($request->user_id) {
			
			$user = User::find($request->user_id);
			$already_exist = $user->groups()->pluck('group_id')->toArray();
			if (!in_array($request->group_id,$already_exist)) {
				$user->groups()->attach($request->group_id);
				return redirect()
					->back()
					->with('message', __('admin.users.groups.index.added-group'));
			} else {
				return redirect()
					->back()
					->with('message', __('admin.users.groups.index.already-in-group'));
			}
		} else {
			$r = $this->group->create($request->except(['_token', '_method']));
			foreach($request->therapist_id as $userid){
				$user = User::find($userid);
				$user->groups()->attach($r->id);
			}
			return redirect('admin/groups')->with([
				'message' => __('admin.groups.index.created-group'),
			]);
		}

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

    public function destroy(string $id,Request $request)
    {
		if ($request->group_id) {
			$this->user->removeGroup($request->group_id, $request->user_id);

			return redirect()
				->back()
				->with('message', __('admin.users.groups.index.removed-group'));
		} else {
			$group = $this->group->findBy('id', $id);

			if (is_null($group)) {
				abort(404);
			}
			
			$this->group->delete($group->id);

			return redirect('admin/groups')->with([
				'message' => __('admin.groups.index.deleted-group'),
			]);
		}
    }
}

