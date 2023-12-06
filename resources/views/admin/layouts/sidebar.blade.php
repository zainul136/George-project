@php
    $segment = Request::segment(1);
    $subSegment = Request::segment(2);
@endphp
<aside class="sidebar sidebar-default sidebar-base navs-rounded-all "
    style="background-image: url({{ asset('admin/images/auth/01.png') }})">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="{{ route('admin:dashboard') }}" class="navbar-brand">
            <!--Logo start-->
            <h4 class="logo-title">{{env('APP_NAME')}}</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            @if (session()->get('type') == 'admin')
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'admins' && $subSegment == 'dashboard' ? 'active' : '' }}"
                            aria-current="page" href="{{ route('admin:dashboard') }}">
                            <i class="icon">
                                <i class="fa fa-home" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Manage</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ $segment == 'clients' ? 'active' : '' }}"
                            href="{{ route('client:list') }}">
                            <i class="icon">
                                <i class="fa fa-users" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Clients</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ $segment == 'project-to-do' ? 'active' : '' }}"
                            href="{{ route('project:to_do_list') }}">
                            <svg class="icon-32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="item-name">To Do</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#sidebar-table" role="button"
                            aria-expanded="false" aria-controls="sidebar-table">
                            <i class="icon">
                                <i class="fas fa-layer-group" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Projects</span>
                            <i class="fas fa-caret-down ml-auto"></i> <!-- Dropdown icon -->
                        </a>
                        <ul class="sub-nav collapse" id="sidebar-table">
                            <li class="nav-item">
                                <a class="nav-link {{ $segment == 'projects' ? 'active' : '' }}"
                                    href="{{ route('project:list') }}">
                                    <i class="icon">
                                        <i class="fas fa-circle" style="font-size:8px;"></i>
                                    </i>
                                    <i class="sidenav-mini-icon"> B </i>
                                    <span class="item-name">Project List</span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            {{-- Access merged data --}}
                            @foreach (getProjectsDropdown() as $item)
                                @if (is_array($item) && isset($item['type']))
                                    {{-- Ordered data --}}
                                    <li class="nav-item" style="list-style: none">
                                        <a class="nav-link collapsed" data-bs-toggle="collapse"
                                            href="#sidebar-{{ $item['type'] }}" role="button"
                                            aria-controls="sidebar-{{ $item['type'] }}">
                                            <i class="icon">
                                                <i class="fas fa-layer-group"></i>
                                            </i>
                                            <span class="item-name">{{ $item['type'] }}</span>
                                            <i class="fas fa-caret-down ml-auto"></i> <!-- Dropdown icon -->
                                            <span class="badge"
                                                style="background: blue; border-radius: 50%;">{{ $item['countYear'] }}</span>
                                        </a>
                                        <ul class="collapse" id="sidebar-{{ $item['type'] }}">
                                            @foreach ($item['years'] as $yearData)
                                                <li class="nav-item" style="list-style: none">
                                                    <a class="nav-link collapsed" data-bs-toggle="collapse"
                                                        href="#sidebar-{{ $yearData['year'] }}" role="button"
                                                        aria-controls="sidebar-{{ $yearData['year'] }}">
                                                        <i class="icon">
                                                            <i class="fas fa-calendar"></i>
                                                        </i>
                                                        <span class="item-name">{{ $yearData['year'] }}</span>
                                                        <i class="fas fa-caret-down ml-auto"></i>
                                                        <!-- Dropdown icon -->
                                                        <span class="badge"
                                                            style="background: blue; border-radius: 50%;">{{ $yearData['count'] }}</span>
                                                    </a>
                                                    <ul class="collapse" id="sidebar-{{ $yearData['year'] }}">
                                                        @foreach ($yearData['names'] as $nameData)
                                                            <li class="nav-item"
                                                                style="list-style: none; margin-left: -90px; ">
                                                                @php
                                                                    // Check if the item has 'type' (ordered data)
                                                                    if (isset($nameData['project_id'])) {
                                                                        $projectId = $nameData['project_id'];
                                                                    }
                                                                @endphp
                                                                <a class="nav-link "
                                                                    href="{{ route('project:view', ['code' => $projectId]) }}">
                                                                    <i class="sidenav-mini-icon"> B </i>
                                                                    <span
                                                                        class="item-name">{{ $nameData['name'] }}</span>
                                                                    <span class="badge"
                                                                        style="background: blue; border-radius: 50%;">{{ $nameData['countName'] }}</span>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    {{-- Unordered data --}}
                                    <li class="nav-item" style="display: none">
                                        @php
                                            // Check if the item has 'project_id' (unordered data)
                                            if (isset($item['project_id'])) {
                                                $projectId = $item['project_id'];
                                            }
                                        @endphp
                                        <a class="nav-link "
                                            href="{{ route('project:view', ['code' => $projectId]) }}">
                                            <i class="sidenav-mini-icon"> B </i>
                                            <span class="item-name">{{ $item['name'] }}</span>
                                            <span class="badge"
                                                style="background: blue; border-radius: 50%;">{{ $item['countName'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                        </ul>
                    </li>

                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Pages</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'companies' ? 'active' : '' }}"
                            href="{{ route('company:list') }}">
                            <i class="icon">
                                <i class="fas fa-building" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Companies</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'employees' ? 'active' : '' }}"
                            href="{{ route('employee:list') }}">
                            <i class="icon">
                                <i class="fas fa-user" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Employees</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'contractors' ? 'active' : '' }}"
                            href="{{ route('contractor:list') }}">
                            <i class="icon">
                                <i class="fas fa-users" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Contractors</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'role_permission' ? 'active' : '' }}"
                            href="{{ route('role:list') }}">
                            <i class="icon">
                                <i class="fas fa-cog" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Roles & Permissions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'admins' && $subSegment != 'dashboard' ? 'active' : '' }}"
                            href="{{ route('admin:list') }}">
                            <i class="icon">
                                <i class="fas fa-shield-alt" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Admins</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $segment == 'invitations' ? 'active' : '' }}"
                            href="{{ route('invite:list') }}">
                            <i class="icon">
                                <i class="fas fa-share" style="font-size:18px;"></i>
                            </i>
                            <span class="item-name">Invitations</span>
                        </a>
                    </li>
                </ul>
            @elseif(session()->get('type') == 'employee')
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    @if ($role[0]->role == 'dashboard' && $role[0]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'admins' && $subSegment == 'dashboard' ? 'active' : '' }}"
                                aria-current="page" href="{{ route('admin:dashboard') }}">
                                <i class="icon">
                                    <i class="fa fa-home" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Dashboard</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Manage</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    @if ($role[4]->role == 'clients' && $role[4]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link  {{ $segment == 'clients' ? 'active' : '' }}"
                                href="{{ route('client:list') }}">
                                <i class="icon">
                                    <i class="fa fa-users" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Clients</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link  {{ $segment == 'project-to-do' ? 'active' : '' }}"
                            href="{{ route('project:to_do_list') }}">
                            <svg class="icon-32" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="item-name">To Do</span>
                        </a>
                    </li>
                    @if ($role[3]->role == 'projects' && $role[3]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'projects' ? 'active' : '' }}"
                                href="{{ route('project:list') }}">
                                <i class="icon">
                                    <i class="fas fa-layer-group" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Projects</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Pages</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    @if ($role[2]->role == 'companies' && $role[2]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'companies' ? 'active' : '' }}"
                                href="{{ route('company:list') }}">
                                <i class="icon">
                                    <i class="fas fa-building" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Companies</span>
                            </a>
                        </li>
                    @endif
                    @if ($role[1]->role == 'employees' && $role[1]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'employees' ? 'active' : '' }}"
                                href="{{ route('employee:list') }}">
                                <i class="icon">
                                    <i class="fas fa-user" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Employees</span>
                            </a>
                        </li>
                    @endif
                    @if ($role[5]->role == 'contractors' && $role[5]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'contractors' ? 'active' : '' }}"
                                href="{{ route('contractor:list') }}">
                                <i class="icon">
                                    <i class="fas fa-users" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Contractors</span>
                            </a>
                        </li>
                    @endif
                    @if ($role[6]->role == 'invitation' && $role[6]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'invitations' ? 'active' : '' }}"
                                href="{{ route('invite:list') }}">
                                <i class="icon">
                                    <i class="fas fa-users" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Invitations</span>
                            </a>
                        </li>
                    @endif
                </ul>
            @elseif(session()->get('type') == 'contractor')
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    @if ($role[7]->role == 'dashboard' && $role[7]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'admins' && $subSegment == 'dashboard' ? 'active' : '' }}"
                                aria-current="page" href="{{ route('admin:dashboard') }}">
                                <i class="icon">
                                    <i class="fa fa-home" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Dashboard</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Manage</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    @if ($role[11]->role == 'clients' && $role[11]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'clients' ? 'active' : '' }}"
                                href="{{ route('client:list') }}">
                                <i class="icon">
                                    <i class="fa fa-users" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Clients</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link  {{ $segment == 'project-to-do' ? 'active' : '' }}"
                            href="{{ route('project:to_do_list') }}">
                            <svg class="icon-32" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.9 2H15.07C17.78 2 19.97 3.07 20 5.79V20.97C20 21.14 19.96 21.31 19.88 21.46C19.75 21.7 19.53 21.88 19.26 21.96C19 22.04 18.71 22 18.47 21.86L11.99 18.62L5.5 21.86C5.351 21.939 5.18 21.99 5.01 21.99C4.45 21.99 4 21.53 4 20.97V5.79C4 3.07 6.2 2 8.9 2ZM8.22 9.62H15.75C16.18 9.62 16.53 9.269 16.53 8.83C16.53 8.39 16.18 8.04 15.75 8.04H8.22C7.79 8.04 7.44 8.39 7.44 8.83C7.44 9.269 7.79 9.62 8.22 9.62Z"
                                    fill="currentColor"></path>
                            </svg>
                            <span class="item-name">To Do</span>
                        </a>
                    </li>
                    @if ($role[10]->role == 'projects' && $role[10]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'projects' ? 'active' : '' }}"
                                href="{{ route('project:list') }}">
                                <i class="icon">
                                    <i class="fas fa-layer-group" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Projects</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Pages</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    @if ($role[9]->role == 'companies' && $role[9]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'companies' ? 'active' : '' }}"
                                href="{{ route('company:list') }}">
                                <i class="icon">
                                    <i class="fas fa-building" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Companies</span>
                            </a>
                        </li>
                    @endif
                    @if ($role[8]->role == 'employees' && $role[8]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'employees' ? 'active' : '' }}"
                                href="{{ route('employee:list') }}">
                                <i class="icon">
                                    <i class="fas fa-user" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Employees</span>
                            </a>
                        </li>
                    @endif
                    @if ($role[12]->role == 'contractors' && $role[12]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'contractors' ? 'active' : '' }}"
                                href="{{ route('contractor:list') }}">
                                <i class="icon">
                                    <i class="fas fa-users" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Contractors</span>
                            </a>
                        </li>
                    @endif
                    @if ($role[13]->role == 'invitation' && $role[13]->permission == '1')
                        <li class="nav-item">
                            <a class="nav-link {{ $segment == 'invitations' ? 'active' : '' }}"
                                href="{{ route('invite:list') }}">
                                <i class="icon">
                                    <i class="fas fa-share" style="font-size:18px;"></i>
                                </i>
                                <span class="item-name">Invitations</span>
                            </a>
                        </li>
                    @endif
                </ul>
            @endif
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>
