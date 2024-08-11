<div class="header-left">
    <a href="index.html" class="logo"> <img src="assets/img/Logo_sooatel.jpg" width="50" height="70" alt="logo"> <span class="logoclass">SOOATEL</span> </a>
    <a href="index.html" class="logo logo-small"> <img src="assets/img/Logo_sooatel.jpg" alt="Logo" width="30" height="30"> </a>
</div>
<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
<ul class="nav user-menu">
    <li class="nav-item dropdown noti-dropdown">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <i class="fe fe-bell"></i> <span class="badge badge-pill">3</span> </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header"> <span class="notification-title">Notifications</span> <a href="javascript:void(0)" class="clear-noti"> Clear All </a> </div>
            <div class="noti-content">
                <ul class="notification-list">
                    <ul class="nav user-menu">
                        <li class="nav-item dropdown noti-dropdown">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="fe fe-bell"></i>
                                <span class="badge badge-pill">{{ $notifications->count() }}</span>
                            </a>
                            <div class="dropdown-menu notifications">
                                <div class="topnav-dropdown-header">
                                    <span class="notification-title">Notifications</span>
                                    <a href="javascript:void(0)" class="clear-noti">Clear All</a>
                                </div>
                                <div class="noti-content">
                                    <ul class="notification-list">
                                        @foreach($notifications as $notification)
                                        <li class="notification-message">
                                            <a href="#">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <p class="noti-details">{{ $notification->message }}</p>
                                                        <p class="noti-time"><span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="topnav-dropdown-footer">
                                    <a href="#">Voir toutes les notifications</a>
                                </div>
                            </div>
                        </li>
                    </ul>



                </ul>
            </div>
            <div class="topnav-dropdown-footer"> <a href="#">View all Notifications</a> </div>
        </div>
    </li>
    <li class="nav-item dropdown has-arrow">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt="Soeng Souy"></span> </a>
        <div class="dropdown-menu">
            <div class="user-header">
                <div class="avatar avatar-sm"> <img src="assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle"> </div>
                <div class="user-text">
                    <h6>Soeng Souy</h6>
                    <p class="text-muted mb-0">Administrator</p>
                </div>
            </div> <a class="dropdown-item" href="profile.html">My Profile</a> <a class="dropdown-item" href="settings.html">Account Settings</a> <a class="dropdown-item" href="login.html">Logout</a> </div>
    </li>
</ul>
<div class="top-nav-search">
    <form>
        <input type="text" class="form-control" placeholder="Search here">
        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    </form>
</div>
