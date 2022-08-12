{{-- @auth --}}
    <aside class="main-sidebar sidebar-light-primary elevation-4">

        <a href="" class="brand-link">
            <img src="{{ asset('assets/backend/dist/img/onepatchnew.png') }}"
                alt="Onepatch Logo" class="brand-image" style="opacity: .8">
            <span class="brand-text">OnePatch DB Support</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item ">
                        <a href="{{ route('dashboard') }}" class="nav-link ">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    @role('super admin')
                    <li class="nav-item ">
                        <a href="{{ route('employee.index') }}" class="nav-link ">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Employee
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ route('company.index') }}" class="nav-link ">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Company
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Admin SetUp
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link">
                                    <span>
                                        <i class="far fa-circle nav-icon"></i>
                                    </span>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('permission.index') }}" class="nav-link">
                                    <span>
                                        <i class="far fa-circle nav-icon"></i>
                                    </span>
                                    <p>Permission</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @else
                    @if(auth()->user()->can('employee'))
                        <li class="nav-item ">
                            <a href="{{ route('employee.index') }}" class="nav-link ">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Employee
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->can('company'))
                        <li class="nav-item ">
                            <a href="{{ route('company.index') }}" class="nav-link ">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Company
                                </p>
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->canany(['roles', 'permissions']))
                    
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Admin SetUp
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if(auth()->user()->can('roles'))
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">
                                            <span>
                                                <i class="far fa-circle nav-icon"></i>
                                            </span>
                                            <p>Roles</p>
                                        </a>
                                    </li>
                                @endif

                                @if(auth()->user()->can('permissions'))
                                    <li class="nav-item">
                                        <a href="{{ route('permission.index') }}" class="nav-link">
                                            <span>
                                                <i class="far fa-circle nav-icon"></i>
                                            </span>
                                            <p>Permission</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif   
                    @endrole

                    

                </ul>

            </nav>
        </div>
    </aside>
{{-- @endauth --}}



{{-- @else
                        @foreach($dynamic_table as $values)
                            @foreach($values as $key=>$value)
                                @if(auth()->user()->hasAnyPermission($value))
                                
                                    <li class="nav-item ">
                                        <a href="{{ route($value . '.' . 'index') }}" class="nav-link ">
                                            <i class="nav-icon fas fa-user"></i>
                                            <p>
                                                {{ $value }}
                                            </p>
                                        </a>
                                    </li> 
                               
                                @endif
                            @endforeach
                        @endforeach --}}