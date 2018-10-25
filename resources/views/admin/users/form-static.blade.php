<table class="table table-bordered table-hover table-sm">
    <tbody>
        <tr class="bg-light">
            <td class="font-weight-bold" colspan="2">
                @lang('admin.users.form-static.basic-information')
            </td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.name')
            </td>
            <td>{{ $user->name }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.email')
            </td>
            <td>{{ $user->email }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.cell-phone')
            </td>
            <td>{{ $user->phone }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.home-phone')
            </td>
            <td>{{ $user->home_phone }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.work-phone')
            </td>
            <td>{{ $user->work_phone }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.doctor')
            </td>
            <td>{{ $user->doctor->name ?? null }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.referrer')
            </td>
            <td>{{ $user->referrer->name ?? null }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.user-since', [
                    'name' => $user->roleName()
                ])
            </td>
            <td>{{ $user->created_at->toDateString() }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.preferred-contact-method')
            </td>
            <td>{{ $user->preferredContactMethod() }}</td>
        </tr>

        @if ($user->isClient())
            <tr>
                <td class="font-weight-bold">
                    @lang('admin.users.form-static.health-card-number')
                </td>
                <td>{{ $user->health_card_number }}</td>
            </tr>
        @endif

        @if (!is_null($user->license))
            <tr>
                <td class="font-weight-bold">
                    @lang('admin.users.form-static.license')
                </td>
                <td>{{ $user->license }}</td>
            </tr>
        @endif

        <tr class="bg-light">
            <td class="font-weight-bold" colspan="2">
                @lang('admin.users.form-static.address')
            </td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.address-line-1')
            </td>
            <td>{{ $user->address_line_1 }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.address-line-2')
            </td>
            <td>{{ $user->address_line_2 }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.city')
            </td>
            <td>{{ $user->city }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.province')
            </td>
            <td>{{ $user->provinceFull() }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.country')
            </td>
            <td>{{ $user->countryFull() }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.postal-code')
            </td>
            <td>{{ $user->postal_code }}</td>
        </tr>

        <tr class="bg-light">
            <td class="font-weight-bold" colspan="2">
                @lang('admin.users.form-static.emergency-contact')
            </td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.emergency-name')
            </td>
            <td>{{ $user->emergency_name }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.emergency-phone')
            </td>
            <td>{{ $user->emergency_phone }}</td>
        </tr>

        <tr>
            <td class="font-weight-bold">
                @lang('admin.users.form-static.emergency-relationship')
            </td>
            <td>{{ $user->emergency_relationship }}</td>
        </tr>

        <tr class="bg-light">
            <td class="font-weight-bold" colspan="2">
                @lang('admin.users.form-static.notes')
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <pre>
                    {{ $user->notes }}
                </pre>
            </td>
        </tr>
    </tbody>
</table>
