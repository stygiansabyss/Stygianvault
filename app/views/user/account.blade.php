<div class="row-fluid">
    <div class="span2">
        <ul class="nav nav-tabs nav-stacked">
            <li class="nav-title"> {{ $activeUser->username }} </li>
            <li><a href="javascript: void(0);" class="ajaxLink" id="profile">Profile</a></li>
            <li><a href="javascript: void(0);" class="ajaxLink" id="settings">Settings</a></li>
        </ul>
    </div>
    <div class="span10">
        <div id="ajaxContent">
            Loading
        </div>
    </div>
</div>

<script>
    @section('onReadyJs')
        $.AjaxLeftTabs('/user/', 'profile');
    @endsection
</script>