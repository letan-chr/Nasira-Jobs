<div class="d-flex justify-content-center">
    @if (!$row->featured)
        <div class="dropdown">
            <a class="btn btn-secondary text-white btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo __('messages.front_settings.make_feature'); ?>
            </a>
            <ul class="fs-6 py-4 dropdown-menu customDropdown" aria-labelledby="dropdownMenuButton1">
                <li><a class="btn btn-sm adminMakeFeatured" data-id="{{ $row->id }}"><?php echo __('messages.front_settings.make_featured'); ?></a>
                </li>
            </ul>
        </div>
    @else
        <div title="{{ __('messages.front_settings.expires_on') }} {{ Carbon\Carbon::parse($row->featured->end_time)->translatedFormat('jS M, Y') }}"data-bs-toggle="tooltip"
            class="dropdown">
            <a class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo __('messages.front_settings.featured'); ?>
                <i class="far fa-check-circle pl-1"></i>
            </a>
            <ul class="fs-6 py-4 dropdown-menu featuredDropdown" aria-labelledby="dropdownMenuButton1">
                <li><a class="btn btn-sm adminUnFeatured" data-id="{{ $row->id }}"><?php echo __('messages.front_settings.remove_featured'); ?></a>
                </li>
            </ul>
    @endif
</div>
</div>
