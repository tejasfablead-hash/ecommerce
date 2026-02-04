 <header class="nxl-header">
     <div class="header-wrapper">
         <!--! [Start] Header Left !-->
         <div class="header-left d-flex align-items-center gap-4">
             <!--! [Start] nxl-head-mobile-toggler !-->
             <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                 <div class="hamburger hamburger--arrowturn">
                     <div class="hamburger-box">
                         <div class="hamburger-inner"></div>
                     </div>
                 </div>
             </a>
             <!--! [Start] nxl-head-mobile-toggler !-->
             <!--! [Start] nxl-navigation-toggle !-->
             <div class="nxl-navigation-toggle">
                 <a href="javascript:void(0);" id="menu-mini-button">
                     <i class="feather-align-left"></i>
                 </a>
                 <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                     <i class="feather-arrow-right"></i>
                 </a>
             </div>
             <!--! [End] nxl-navigation-toggle !-->
             <!--! [Start] nxl-lavel-mega-menu-toggle !-->
             <div class="nxl-lavel-mega-menu-toggle d-flex d-lg-none">
                 <a href="javascript:void(0);" id="nxl-lavel-mega-menu-open">
                     <i class="feather-align-left"></i>
                 </a>
             </div>
             <!--! [End] nxl-lavel-mega-menu-toggle !-->
             <!--! [Start] nxl-lavel-mega-menu !-->
             {{-- <div class="nxl-drp-link nxl-lavel-mega-menu">
                    <div class="nxl-lavel-mega-menu-toggle d-flex d-lg-none">
                        <a href="javascript:void(0)" id="nxl-lavel-mega-menu-hide">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <!--! [Start] nxl-lavel-mega-menu-wrapper !-->
                    <div class="nxl-lavel-mega-menu-wrapper d-flex gap-3">
                        <!--! [Start] nxl-lavel-menu !-->
                        <div class="dropdown nxl-h-item nxl-lavel-menu">
                            <a href="javascript:void(0);" class="avatar-text avatar-md bg-primary text-white" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="feather-plus"></i>
                            </a>
                            <div class="dropdown-menu nxl-h-dropdown">
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-send"></i>
                                            <span>Applications</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="apps-chat.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Chat</span>
                                        </a>
                                        <a href="apps-email.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Email</span>
                                        </a>
                                        <a href="apps-tasks.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Tasks</span>
                                        </a>
                                        <a href="apps-notes.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Notes</span>
                                        </a>
                                        <a href="apps-storage.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Storage</span>
                                        </a>
                                        <a href="apps-calendar.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Calendar</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-cast"></i>
                                            <span>Reports</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="reports-sales.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Sales Report</span>
                                        </a>
                                        <a href="reports-leads.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Leads Report</span>
                                        </a>
                                        <a href="reports-project.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Project Report</span>
                                        </a>
                                        <a href="reports-timesheets.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Timesheets Report</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-at-sign"></i>
                                            <span>Proposal</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="proposal.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Proposal</span>
                                        </a>
                                        <a href="proposal-view.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Proposal View</span>
                                        </a>
                                        <a href="proposal-edit.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Proposal Edit</span>
                                        </a>
                                        <a href="proposal-create.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Proposal Create</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-dollar-sign"></i>
                                            <span>Payment</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="payment.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Payment</span>
                                        </a>
                                        <a href="invoice-view.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Invoice View</span>
                                        </a>
                                        <a href="invoice-create.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Invoice Create</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-users"></i>
                                            <span>Customers</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="customers.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Customers</span>
                                        </a>
                                        <a href="customers-view.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Customers View</span>
                                        </a>
                                        <a href="customers-create.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Customers Create</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-alert-circle"></i>
                                            <span>Leads</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="leads.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Leads</span>
                                        </a>
                                        <a href="leads-view.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Leads View</span>
                                        </a>
                                        <a href="leads-create.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Leads Create</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-briefcase"></i>
                                            <span>Projects</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="projects.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Projects</span>
                                        </a>
                                        <a href="projects-view.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Projects View</span>
                                        </a>
                                        <a href="projects-create.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Projects Create</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-layout"></i>
                                            <span>Widgets</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <a href="widgets-lists.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Lists</span>
                                        </a>
                                        <a href="widgets-tables.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Tables</span>
                                        </a>
                                        <a href="widgets-charts.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Charts</span>
                                        </a>
                                        <a href="widgets-statistics.html" class="dropdown-item">
                                            <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                            <span>Statistics</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown nxl-level-menu">
                                    <a href="javascript:void(0);" class="dropdown-item">
                                        <span class="hstack">
                                            <i class="feather-power"></i>
                                            <span>Authentication</span>
                                        </span>
                                        <i class="feather-chevron-right ms-auto me-0"></i>
                                    </a>
                                    <div class="dropdown-menu nxl-h-dropdown">
                                        <div class="dropdown nxl-level-menu">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <span class="hstack">
                                                    <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                                    <span>Login</span>
                                                </span>
                                                <i class="feather-chevron-right ms-auto me-0"></i>
                                            </a>
                                        
                                        </div>
                                        <div class="dropdown nxl-level-menu">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <span class="hstack">
                                                    <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                                    <span>Register</span>
                                                </span>
                                                <i class="feather-chevron-right ms-auto me-0"></i>
                                            </a>
                                           
                                        </div>
                                        <div class="dropdown nxl-level-menu">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <span class="hstack">
                                                    <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                                    <span>Error-404</span>
                                                </span>
                                                <i class="feather-chevron-right ms-auto me-0"></i>
                                            </a>
                                         
                                        </div>
                                        <div class="dropdown nxl-level-menu">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <span class="hstack">
                                                    <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                                    <span>Reset Pass</span>
                                                </span>
                                                <i class="feather-chevron-right ms-auto me-0"></i>
                                            </a>
                                        
                                        </div>
                                        <div class="dropdown nxl-level-menu">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <span class="hstack">
                                                    <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                                    <span>Verify OTP</span>
                                                </span>
                                                <i class="feather-chevron-right ms-auto me-0"></i>
                                            </a>
                                      
                                        </div>
                                        <div class="dropdown nxl-level-menu">
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <span class="hstack">
                                                    <i class="wd-5 ht-5 bg-gray-500 rounded-circle me-3"></i>
                                                    <span>Maintenance</span>
                                                </span>
                                                <i class="feather-chevron-right ms-auto me-0"></i>
                                            </a>
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                            </div>
                        </div>
                        <!--! [End] nxl-lavel-menu !-->
                        <!--! [Start] nxl-h-item nxl-mega-menu !-->
                       
                        <!--! [End] nxl-h-item nxl-mega-menu !-->
                    </div>
                    <!--! [End] nxl-lavel-mega-menu-wrapper !-->
                </div> --}}
             <!--! [End] nxl-lavel-mega-menu !-->
         </div>
         <!--! [End] Header Left !-->
         <!--! [Start] Header Right !-->
         <div class="header-right ms-auto">
             <div class="d-flex align-items-center">
                 <div class="dropdown nxl-h-item nxl-header-search">
                     <a href="javascript:void(0);" class="nxl-head-link me-0" data-bs-toggle="dropdown"
                         data-bs-auto-close="outside">
                         <i class="feather-search"></i>
                     </a>

                     <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-search-dropdown">
                         <div class="input-group search-form">
                             <span class="input-group-text">
                                 <i class="feather-search fs-6 text-muted"></i>
                             </span>
                             <input type="text" class="form-control search-input-field" id="admin-search"
                                 placeholder="Search...." autocomplete="off" />
                             <span class="input-group-text">
                                 <button type="button" class="btn-close"></button>
                             </span>
                         </div>

                         <div class="dropdown-divider mt-0"></div>

                         <div id="search-results" class="p-2" style="max-height:300px; overflow-y:auto;">
                             <div class="text-muted text-center">Type to search...</div>
                         </div>
                     </div>
                 </div>


                 <div class="nxl-h-item d-none d-sm-flex">
                     <div class="full-screen-switcher">
                         <a href="javascript:void(0);" class="nxl-head-link me-0"
                             onclick="$('body').fullScreenHelper('toggle');">
                             <i class="feather-maximize maximize"></i>
                             <i class="feather-minimize minimize"></i>
                         </a>
                     </div>
                 </div>
                 <div class="nxl-h-item dark-light-theme">
                     <a href="javascript:void(0);" class="nxl-head-link me-0 dark-button">
                         <i class="feather-moon"></i>
                     </a>
                     <a href="javascript:void(0);" class="nxl-head-link me-0 light-button" style="display: none">
                         <i class="feather-sun"></i>
                     </a>
                 </div>

                 <div class="dropdown nxl-h-item">
                     <a class="nxl-head-link me-3" data-bs-toggle="dropdown" href="#" role="button"
                         data-bs-auto-close="outside">
                         <i class="feather-bell"></i>
                         <span class="badge bg-danger nxl-h-badge" id="order-count">0</span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-notifications-menu" id="order-list">
                         <div class="d-flex justify-content-between align-items-center notifications-head">
                             <h6 class="fw-bold text-dark mb-0">New Orders</h6>
                             <a href="javascript:void(0);" class="fs-11 text-success text-end ms-auto" id="mark-read">
                                 <i class="feather-check"></i> Mark All as Read
                             </a>
                         </div>
                         <div class="notifications-body mt-2" id="notifications-body">
                             <!-- Dynamic order notifications will appear here -->
                         </div>
                         {{-- <div class="text-center notifications-footer mt-2">
            <a href="" class="fs-13 fw-semibold text-dark">View All Orders</a>
        </div> --}}
                     </div>
                 </div>

                 <div class="dropdown nxl-h-item">
                     <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button"
                         data-bs-auto-close="outside">
                         @if (Auth::check())
                             <img src="{{ asset('storage/user/' . Auth::user()->image) }}" alt="user-image"
                                 class="img-fluid user-avtar me-0" />
                         @else
                             <img src="{{ asset('assets/images/avatar/1.png') }}" alt="user-image"
                                 class="img-fluid user-avtar" />
                         @endif
                     </a>
                     <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                         <div class="dropdown-header">
                             <div class="d-flex align-items-center">
                                 @if (Auth::check())
                                     <img src="{{ asset('storage/user/' . Auth::user()->image) }}" alt="user-image"
                                         class="img-fluid user-avtar" />
                                 @else
                                     <img src="{{ asset('assets/images/avatar/1.png') }}" alt="user-image"
                                         class="img-fluid user-avtar" />
                                 @endif

                                 <div>
                                     <h6 class="text-dark mb-0 text-capitalize">{{ Auth::user()->name ?? 'Guest' }}
                                         <span class="badge bg-soft-success text-success ms-1">PRO</span>
                                     </h6>
                                     <span class="fs-12 fw-medium text-muted">{{ Auth::user()->email ?? '' }}</span>
                                 </div>
                             </div>
                         </div>
                         {{-- <div class="dropdown">
                             <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="dropdown">
                                 <span class="hstack">
                                     <i
                                         class="wd-10 ht-10 border border-2 border-gray-1 bg-success rounded-circle me-2"></i>
                                     <span>Active</span>
                                 </span>
                                 <i class="feather-chevron-right ms-auto me-0"></i>
                             </a> --}}
                         {{-- <div class="dropdown-menu">
                                 <a href="javascript:void(0);" class="dropdown-item">
                                     <span class="hstack">
                                         <i
                                             class="wd-10 ht-10 border border-2 border-gray-1 bg-warning rounded-circle me-2"></i>
                                         <span>Always</span>
                                     </span>
                                 </a>
                                 <a href="javascript:void(0);" class="dropdown-item">
                                     <span class="hstack">
                                         <i
                                             class="wd-10 ht-10 border border-2 border-gray-1 bg-success rounded-circle me-2"></i>
                                         <span>Active</span>
                                     </span>
                                 </a>
                                 <a href="javascript:void(0);" class="dropdown-item">
                                     <span class="hstack">
                                         <i
                                             class="wd-10 ht-10 border border-2 border-gray-1 bg-danger rounded-circle me-2"></i>
                                         <span>Bussy</span>
                                     </span>
                                 </a>
                                 <a href="javascript:void(0);" class="dropdown-item">
                                     <span class="hstack">
                                         <i
                                             class="wd-10 ht-10 border border-2 border-gray-1 bg-info rounded-circle me-2"></i>
                                         <span>Inactive</span>
                                     </span>
                                 </a>
                                 <a href="javascript:void(0);" class="dropdown-item">
                                     <span class="hstack">
                                         <i
                                             class="wd-10 ht-10 border border-2 border-gray-1 bg-dark rounded-circle me-2"></i>
                                         <span>Disabled</span>
                                     </span>
                                 </a>
                                 <div class="dropdown-divider"></div>
                                 <a href="javascript:void(0);" class="dropdown-item">
                                     <span class="hstack">
                                         <i
                                             class="wd-10 ht-10 border border-2 border-gray-1 bg-primary rounded-circle me-2"></i>
                                         <span>Cutomization</span>
                                     </span>
                                 </a>
                             </div> 
                         </div>
                         <div class="dropdown-divider"></div> --}}
                         <a href="{{ route('ProfilesPage') }}" class="dropdown-item">
                             <i class="feather-user"></i>
                             <span>Profile Details</span>
                         </a>
                         {{-- <a href="javascript:void(0);" class="dropdown-item">
                             <i class="feather-settings"></i>
                             <span>Account Settings</span>
                         </a> --}}
                         <div class="dropdown-divider"></div>
                         <a href="javascript:void(0);" data-redirect="{{ route('LoginPage') }}"
                             class="dropdown-item logout-btn">
                             <i class="feather-log-out"></i>
                             <span>Logout</span>
                         </a>
                     </div>
                 </div>
             </div>
         </div>
         <!--! [End] Header Right !-->
     </div>
 </header>
 <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
     crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script src="{{ asset('ajax.js') }}"></script>

 <script>
     $(document).ready(function() {
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         $(document).on('keyup', '#admin-search', function() {
             let query = $(this).val();

             if (query.length < 2) {
                 $('#search-results').html(
                     '<div class="text-muted text-center">Type at least 2 characters</div>'
                 );
                 return;
             }

             $.ajax({
                 url: "{{ route('AdminSearch') }}",
                 type: "GET",
                 data: {
                     q: query
                 },
                 success: function(res) {
                     let html = '';

                     if (
                         res.orders.length === 0 &&
                         res.transactionId.length === 0 &&
                         res.status.length === 0 &&
                         res.users.length === 0 &&
                         res.products.length === 0
                     ) {
                         html = '<div class="text-center text-muted">No result found</div>';
                     }

                     if (res.orders.length > 0) {
                         html += `<div class="fw-bold mb-1">Orders</div>`;
                         res.orders.forEach(o => {
                             html += `
                        <a href="/admin/order-details/${o.id}" class="d-block py-1 text-dark">
                            #${o.order_number}
                        </a>`;
                         });
                     }
                     if (res.transactionId.length > 0) {
                         html += `<div class="fw-bold mt-2 mb-1">Transaction Id</div>`;
                         res.transactionId.forEach(u => {
                             html += `
                        <div class="py-1">${u.transactionId}</div>`;
                         });
                     }
                     if (res.status.length > 0) {
                         res.status.forEach(order => {
                             html += `
        <div class="search-item">
            <strong>#${order.order_number}</strong>
            <span class="badge bg-info ms-2">
                ${order.order_status}
            </span>
            <br>
            <small>₹${order.grand_total}</small>
        </div>
        `;
                         });
                     }


                     if (res.users.length > 0) {
                         html += `<div class="fw-bold mt-2 mb-1">Users</div>`;
                         res.users.forEach(u => {
                             html += `
                        <div class="py-1">${u.name}</div>`;
                         });
                     }

                     if (res.products.length > 0) {
                         html += `<div class="fw-bold mt-2 mb-1">Products</div>`;
                         res.products.forEach(p => {
                             html += `
                        <a href="/admin/product-details/${p.id}" class="d-block py-1 text-dark">
                            #${p.name}
                        </a>`
                         });
                     }

                     $('#search-results').html(html);
                 }
             });
         });


         $(document).on('click', '.logout-btn', function(e) {
             e.preventDefault();
             let redirectUrl = $(this).data('redirect');
             var url = "{{ route('LogoutPage') }}"
             reusableAjaxCall(url, 'POST', null, function(response) {
                 console.log('response', response);
                 if (response.status == true) {
                     Swal.fire({
                         toast: true,
                         position: "top-end",
                         icon: "success",
                         title: response.message,
                         showConfirmButton: false,
                         timer: 3000
                     });
                     setTimeout(() => {
                         window.location.href = redirectUrl;
                     }, 1500);
                 }
             });
         });

         function loadOrderNotifications() {
             $.ajax({
                 url: "{{ route('OrdernotificationsPage') }}",
                 type: 'GET',
                 success: function(res) {
                     $('#order-count').text(res.count);

                     let html = '';
                     if (res.orders.length > 0) {
                         res.orders.forEach(order => {
                             html += `
                            <div class="notifications-item p-2 border-bottom">
                                <div class="notifications-desc">
                                    <a href="{{ url('/admin/order-details') }}/` + order.id + `" class="text-truncate text-capitalize">
                                        <span class="fw-semibold text-dark text-capitalize"> #${order.order_number}</span> - ${order.getcustomer.name}
                                    </a>
                                    <div class="text-muted fs-12">${new Date(order.created_at).toLocaleString()}</div>
                                </div>
                            </div>
                        `;
                         });
                     } else {
                         html = '<div class="text-center p-2 text-muted">No new orders</div>';
                     }
                     $('#notifications-body').html(html);
                 },
                 error: function(err) {
                     console.error(err);
                 }
             });
         }

         loadOrderNotifications();

         setInterval(loadOrderNotifications, 30000);


     });
 </script>
 <script>
     document.addEventListener('keydown', function(e) {
         if (e.key === 'Escape') {

             const searchDropdown = document.querySelector('.nxl-header-search .dropdown-menu.show');
             const toggleBtn = document.querySelector('.nxl-header-search [data-bs-toggle="dropdown"]');

             if (searchDropdown && toggleBtn) {
                 bootstrap.Dropdown.getOrCreateInstance(toggleBtn).hide();
             }
         }
     });
 </script>
