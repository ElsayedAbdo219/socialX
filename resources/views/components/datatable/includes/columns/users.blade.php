@isset($users)

    <td class="">
        @foreach ($users as $user)
            <span class="badge badge-pill badge-primary p-2"> {{ $user->name }}</span>
        @endforeach
    </td>

@endisset
