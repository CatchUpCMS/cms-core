<a href="{{ route('administrator.navigation.menu.edit', [$menu->navigation_id, $menu->id]) }}">
    {{ $menu->present()->indentedTitle(1, '|— ') }}
</a>
<small>(URL: {{ $menu->present()->url }})</small>
<br>
<small><span class="label label-info">MENU TYPE:</span> <span class="label label-success">{{ $menu->extension->name }}</span></small>
