@props(['page'])

<aside
	:class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
	class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
	<!-- SIDEBAR HEADER -->
	<div :class="sidebarToggle ? 'justify-center' : 'justify-between'" class="flex items-center gap-2 pt-3 sidebar-header pb-2">
		<a href="{{ route('dashboard') }}">
			<span class="logo" :class="sidebarToggle ? 'hidden' : ''">
				<img class="dark:hidden" src="{{ asset('compressed/logo.svg') }}" alt="Logo" />
				<img class="hidden dark:block" src="{{ asset('compressed/logo-dark.svg') }}" alt="Logo" />
			</span>
			<img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'" src="{{ asset('compressed/icon.svg') }}" alt="Logo" />
		</a>
	</div>
	<!-- SIDEBAR HEADER -->

	<div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
		<!-- Sidebar Menu -->
		<nav x-data="{ selected: $persist('Dashboard') }">
			<!-- Menu Group -->
			<div>
				<h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
					<span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">MENU</span>
					<svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M6 10.25a1.75 1.75 0 113.5 0v.01a1.75 1.75 0 11-3.5 0v-.01zm12 0a1.75 1.75 0 113.5 0v.01a1.75 1.75 0 11-3.5 0v-.01zM13.75 12a1.75 1.75 0 11-3.5 0v-.01a1.75 1.75 0 113.5 0V12z" fill="currentColor"/>
					</svg>
				</h3>

				<ul class="flex flex-col gap-4 mb-6">
					<!-- Dashboard -->
					<li>
						<a href="{{ route('dashboard') }}" class="menu-item group" :class="page === 'dashboard' ? 'menu-item-active' : 'menu-item-inactive'">
						 <svg
			:class="page === 'dashboard' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
		>
			<path
				fill-rule="evenodd"
				clip-rule="evenodd"
				d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z"
				fill=""
			/>
		</svg>
							<span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
						</a>
					</li>

					<!-- Data Master -->
					<li>
						<a href="#" @click.prevent="selected = (selected === 'DataMaster' ? '' : 'DataMaster')" class="menu-item group"
							:class="(selected === 'DataMaster') || (['customers', 'users', 'services'].includes(page)) ? 'menu-item-active' : 'menu-item-inactive'">
							<svg :class="(selected === 'DataMaster') || (['customers', 'users', 'services'].includes(page)) ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
								width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.26 3.25 3.25 4.26 3.25 5.5v13c0 1.24 1.01 2.25 2.25 2.25h13c1.24 0 2.25-1.01 2.25-2.25v-13C20.75 4.26 19.74 3.25 18.5 3.25h-13zM4.75 5.5A.75.75 0 015.5 4.75h13a.75.75 0 01.75.75v13a.75.75 0 01-.75.75h-13a.75.75 0 01-.75-.75v-13zM6.25 9.714c0-.414.336-.75.75-.75h10a.75.75 0 110 1.5H7a.75.75 0 01-.75-.75zM6.25 14.286c0-.414.336-.75.75-.75h10a.75.75 0 110 1.5H7a.75.75 0 01-.75-.75z" fill="currentColor"/>
							</svg>
							<span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Data Master</span>
							<svg class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
								:class="[(selected === 'DataMaster') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '']"
								width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</a>

						<!-- Dropdown -->
						<div class="overflow-hidden transform translate" :class="(selected === 'DataMaster') ? 'block' : 'hidden'">
							<ul :class="sidebarToggle ? 'lg:hidden' : 'flex'" class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
								<li>
									<a href="{{ route('customers.index') }}" class="menu-dropdown-item group" :class="page === 'customers' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Customers</a>
								</li>
								<li>
									<a href="{{ route('users.index') }}" class="menu-dropdown-item group" :class="page === 'users' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Users</a>
								</li>
								<li>
									<a href="{{ route('type_of_services.index') }}" class="menu-dropdown-item group" :class="page === 'services' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">Services</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div>

            <div>
				<h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
					<span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">Operator</span>
					<svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'" class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M6 10.25a1.75 1.75 0 113.5 0v.01a1.75 1.75 0 11-3.5 0v-.01zm12 0a1.75 1.75 0 113.5 0v.01a1.75 1.75 0 11-3.5 0v-.01zM13.75 12a1.75 1.75 0 11-3.5 0v-.01a1.75 1.75 0 113.5 0V12z" fill="currentColor"/>
					</svg>
				</h3>

				<ul class="flex flex-col gap-4 mb-6">
					<!-- orders -->
					<li>
						<a href="{{ route('orders.index') }}" class="menu-item group" :class="page === 'orders' ? 'menu-item-active' : 'menu-item-inactive'">
						 <svg
			:class="page === 'orders' ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
			width="24"
			height="24"
			viewBox="0 0 24 24"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
		>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z" fill=""></path>
		</svg>
							<span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Orders</span>
						</a>
					</li>

					
				</ul>
			</div>

		</nav>
	</div>
</aside>