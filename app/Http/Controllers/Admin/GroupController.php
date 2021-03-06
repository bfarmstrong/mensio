<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupCreateRequest;
use App\Models\Group;
use App\Models\User;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IGroupService;
use App\Services\Impl\IUserService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    protected $group;
    protected $user;

    /**
     * Creates an instance of `GroupController`.
     *
     * @param IGroupService $service
     */
    public function __construct(IGroupService $group, IUserService $user)
    {
        $this->group = $group;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $request->user_id ?? null;

        if ($request->user()->isAdmin()) {
            $groups = $this->group->paginate();
            if ($user) {
                $user = $this->user->find($user);
                $userGroups = $this->group->findByClient($user);

                return view('admin.users.groups.index')->with([
                    'all_groups' => $groups->reject(function ($value) use ($userGroups) {
                        return $userGroups->contains($value);
                    }),
                    'groups' => $userGroups,
                    'user' => $user,
                ]);
            }

            return view('admin.groups.index')->with([
                'groups' => $groups,
            ]);
        }

        $groups = $this->group
            ->getByCriteria(
                new WhereRelationEqual(
                    'users',
                    'users.id',
                    $request->user()->id
                )
            )
            ->paginate();

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

        if ($request->user()->isAdmin()) {
            $groups = $this->group->search($request->search);
        } else {
            $user = User::find(\Auth::user()->id);
            $groups = $user->groups()->where('name', '=', $request->search)->paginate();
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

        $therapists = $therapists->sortBy('name');

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
            if (! in_array($request->group_id, $already_exist)) {
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
            foreach ($request->therapist_id as $userid) {
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
    public function edit(string $uuid)
    {
        $group = $this->group->findBy('uuid', $uuid);
        $users_id = $group->users()->pluck('user_id');

        $therapists = $this->user
            ->pushCriteria(new WhereTherapist())
            ->pushCriteria(new WithRole())
            ->all();

        $therapists = $therapists->sortBy('name');

        return view('admin.groups.edit')->with([
            'group' => $group,
            'therapists' => $therapists,
            'users_id' => $users_id,
        ]);
    }

    /**
     * Updates a group in the database.  Syncs the list of therapists.
     *
     * @param Request $request
     * @param string  $uuid
     *
     * @return Response
     */
    public function update(Request $request, string $uuid)
    {
        return DB::transaction(function () use ($request, $uuid) {
            $group = $this->group->findBy('uuid', $uuid);

            $this->group->update(
                $group,
                $request->except(['_token', '_method'])
            );

            $therapists = $this->group->findTherapists($group);
            $users = $group->users();
            foreach ($therapists as $therapist) {
                $users->detach($therapist->id);
            }

            foreach ($request->therapist_id as $therapist) {
                $therapist = $this->user->find($therapist);
                $users->attach($therapist->id);
            }

            return back()->with([
                'message' => __('admin.groups.index.updated-group'),
            ]);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function destroy(string $uuid, Request $request)
    {
        if ($request->group_id) {
            $this->user->removeGroup($request->group_id, $request->user_id);

            return redirect()
                ->back()
                ->with('message', __('admin.users.groups.index.removed-group'));
        } else {
            $group = $this->group->findBy('uuid', $uuid);

            $users = $group->users()->get();
            foreach ($users as $user) {
                $group->users()->detach($user->user_id);
            }
            $this->group->delete($group->id);

            return redirect('admin/groups')->with([
                'message' => __('admin.groups.index.deleted-group'),
            ]);
        }
    }
}
