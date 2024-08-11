<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="active"> <a href="{{url('/')}}"><i class="fas fa-tachometer-alt"></i> <span>Acceuil</span></a> </li>
            <li class="list-divider"></li>
            <li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Reservation chambre</span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="{{url('view_reservations')}}">liste </a></li>

                    <li><a href="{{url('create_reservation')}}"> ajout </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Reservation salle</span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="{{url('view_salle')}}">liste </a></li>

                    <li><a href="{{url('create_salle')}}"> ajout </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-key"></i> <span>chambre </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="{{url('view_chambre')}}">liste chambre</a></li>

                    <li><a href="{{url('create_chambre')}}"> ajout chambre</a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-key"></i> <span> Salle </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="{{url('view_salle')}}">liste salle</a></li>

                    <li><a href="{{url('create_salle')}}"> ajout salle</a></li>
                </ul>
            </li>
            <li> <a href="{{url('statistiques')}}"><i class="far fa-chart-bar"></i> <span>statistiques</span></a> </li>
            <li> <a href="{{url('planning_reservation')}}"><i class="far fa-calendar"></i> <span>calendrier</span></a> </li>

            <li class="submenu"> <a href="#"><i class="fas fa-share-alt"></i> <span>  </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="chat.html"><i class="fas fa-comments"></i><span> Chat </span></a></li>
                    <li class="submenu"> <a href="#"><i class="fas fa-video camera"></i> <span> Calls </span> <span class="menu-arrow"></span></a>
                        <ul class="submenu_class" style="display: none;">
                            <li><a href="voice-call.html"> Voice Call </a></li>
                            <li><a href="video-call.html"> Video Call </a></li>
                            <li><a href="incoming-call.html"> Incoming Call </a></li>
                        </ul>
                    </li>
                    <li class="submenu"> <a href="#"><i class="fas fa-envelope"></i> <span> Email </span> <span class="menu-arrow"></span></a>
                        <ul class="submenu_class" style="display: none;">
                            <li><a href="compose.html">Compose Mail </a></li>
                            <li><a href="inbox.html"> Inbox </a></li>
                            <li><a href="mail-veiw.html"> Mail Veiw </a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Employees </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="employees.html">Employees List </a></li>
                    <li><a href="leaves.html">Leaves </a></li>
                    <li><a href="holidays.html">Holidays </a></li>
                    <li><a href="attendance.html">Attendance </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="far fa-money-bill-alt"></i> <span> Accounts </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="invoices.html">Invoices </a></li>
                    <li><a href="payments.html">Payments </a></li>
                    <li><a href="expenses.html">Expenses </a></li>
                    <li><a href="taxes.html">Taxes </a></li>
                    <li><a href="provident-fund.html">Provident Fund </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-book"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="salary.html">Employee Salary </a></li>
                    <li><a href="salary-veiw.html">Payslip </a></li>
                </ul>
            </li>
            <li> <a href="calendar.html"><i class="fas fa-calendar-alt"></i> <span>Calendar</span></a> </li>
            <li class="submenu"> <a href="#"><i class="fe fe-table"></i> <span> Blog </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="blog.html">Blog </a></li>
                    <li><a href="blog-details.html">Blog Veiw </a></li>
                    <li><a href="add-blog.html">Add Blog </a></li>
                    <li><a href="edit-blog.html">Edit Blog </a></li>
                </ul>
            </li>
            <li> <a href="assets.html"><i class="fas fa-cube"></i> <span>Assests</span></a> </li>
            <li> <a href="activities.html"><i class="far fa-bell"></i> <span>Activities</span></a> </li>
            <li class="submenu"> <a href="#"><i class="fe fe-table"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="expense-reports.html">Expense Report </a></li>
                    <li><a href="invoice-reports.html">Invoice Report </a></li>
                </ul>
            </li>
            <li> <a href="settings.html"><i class="fas fa-cog"></i> <span>Settings</span></a> </li>
            <li class="list-divider"></li>
            <li class="menu-title mt-3"> <span>UI ELEMENTS</span> </li>
            <li class="submenu"> <a href="#"><i class="fas fa-laptop"></i> <span> Components </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="uikit.html">UI Kit </a></li>
                    <li><a href="typography.html">Typography </a></li>
                    <li><a href="tabs.html">Tabs </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-edit"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="form-basic-inputs.html">Basic Input </a></li>
                    <li><a href="form-input-groups.html">Input Groups </a></li>
                    <li><a href="form-horizontal.html">Horizontal Form </a></li>
                    <li><a href="form-vertical.html">Vertical Form </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="tables-basic.html">Basic Table </a></li>
                    <li><a href="tables-datatables.html">Data Table </a></li>
                </ul>
            </li>
            <li class="list-divider"></li>
            <li class="menu-title mt-3"> <span>EXTRAS</span> </li>
            <li class="submenu"> <a href="#"><i class="fas fa-columns"></i> <span> Pages </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="login.html">Login </a></li>
                    <li><a href="register.html">Register </a></li>
                    <li><a href="forgot-password.html">Forgot Password </a></li>
                    <li><a href="change-password.html">Change Password </a></li>
                    <li><a href="lock-screen.html">Lockscreen </a></li>
                    <li><a href="profile.html">Profile </a></li>
                    <li><a href="gallery.html">Gallery </a></li>
                    <li><a href="error-404.html">404 Error </a></li>
                    <li><a href="error-500.html">500 Error </a></li>
                    <li><a href="blank-page.html">Blank Page </a></li>
                </ul>
            </li>
            <li class="submenu"> <a href="#"><i class="fas fa-share-alt"></i> <span> Multi Level </span> <span class="menu-arrow"></span></a>
                <ul class="submenu_class" style="display: none;">
                    <li><a href="">Level 1 </a></li>
                    <li><a href="">Level 2 </a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
