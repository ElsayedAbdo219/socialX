@isset($store_category)

    <td class="">
        @foreach ($store_category as $category)
            <span class="badge badge-pill badge-primary p-2"> {{ $category->title }}</span>
        @endforeach
    </td>

@endisset
