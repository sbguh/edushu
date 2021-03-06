<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-group"></i> Authentication</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Users</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
	</ul>
</li>


<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class=nav-item><a class=nav-link href="{{ backpack_url('elfinder') }}"><i class="nav-icon fa fa-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon fa fa-cog'></i> <span>Settings</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon fa fa-file-o'></i> <span>Pages</span></a></li>

<li><a href="{{ backpack_url('menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-newspaper-o"></i>News</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('article') }}"><i class="nav-icon fa fa-newspaper-o"></i> Articles</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon fa fa-list"></i> Categories</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon fa fa-tag"></i> Tags</a></li>
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon fa fa-terminal'></i> Logs</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon fa fa-hdd-o'></i> Backups</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('useraddress') }}'><i class='nav-icon fa fa-question'></i> UserAddresses</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('icon') }}'><i class='nav-icon fa fa-question'></i> Icons</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product') }}'><i class='nav-icon fa fa-question'></i> Products</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('productsku') }}'><i class='nav-icon fa fa-question'></i> ProductSkus</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('chapter') }}'><i class='nav-icon fa fa-question'></i> Chapters</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('book') }}'><i class='nav-icon fa fa-question'></i> Books</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('cartitem') }}'><i class='nav-icon fa fa-question'></i> CartItems</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon fa fa-question'></i> Categories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('bookaudio') }}'><i class='nav-icon fa fa-question'></i> BookAudios</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('chapteraudio') }}'><i class='nav-icon fa fa-question'></i> ChapterAudios</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('userbookhistory') }}'><i class='nav-icon fa fa-question'></i> UserBookHistories</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('vipcard') }}'><i class='nav-icon fa fa-question'></i> VipCards</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('activity') }}'><i class='nav-icon fa fa-question'></i> Activities</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('activity') }}'><i class='nav-icon fa fa-question'></i> Activities</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('productsku') }}'><i class='nav-icon fa fa-question'></i> ProductSkus</a></li>