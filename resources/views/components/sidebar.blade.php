<aside
	class="flex h-full w-full flex-col items-center gap-3 border-r border-gray-200 bg-white px-4 pt-8 dark:border-gray-800 dark:bg-gray-900 md:w-auto"
	x-show="sidebar"
	x-transition:enter="transition transform duration-300"
	x-transition:enter-start="-translate-x-full"
	x-transition:enter-end="translate-x-0"
	x-transition:leave="transition transform duration-300"
	x-transition:leave-start="translate-x-0"
	x-transition:leave-end="-translate-x-full">
	<button class="me-auto px-1 pt-1 dark:border-gray-700"
		x-show="width <= 768"
		@click="sidebar = !sidebar">
		<span class="material-symbols-outlined">
			sort
		</span>
	</button>
	<div class="mb-5 flex w-full items-center justify-center gap-3">
		{{-- <img class="rounded-lg"
			src="{{ asset("images/monkey.jpeg") }}"
			alt=""
			width="25"
			height="25"> --}}
		<span class="material-symbols-outlined">
			fingerprint
		</span>
		<h1 class="text-md font-bold">BIOMETRIC</h1>
	</div>
	<ul class="flex w-full flex-col gap-3">
		<span class="text-xs text-gray-400">MENU</span>
		<li>
			<a
				class="{{ request()->routeIs("home") ? "bg-blue-100 text-blue-700 dark:bg-gray-700" : "" }} flex w-full flex-row items-center justify-between gap-3 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
				href="{{ route("home") }}">
				<div class="flex items-center gap-3">
					<span class="material-symbols-outlined">
						monitoring
					</span>
					<h1>
						Dashboard
					</h1>
				</div>
			</a>
		</li>
		{{-- <li class="flex flex-col gap-1"
			x-data="{ open: false }">
			<button
				class="flex w-full flex-row items-center justify-between gap-3 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
				@click="open = !open">
				<div class="flex items-center gap-3">
					<span class="material-symbols-outlined">
						monitoring
					</span>
					<h1>
						Dashboard
					</h1>
				</div>
				<span x-transition.duration.300ms
					:class="open ? 'hidden' : 'material-symbols-outlined'">
					keyboard_arrow_down
				</span>
				<span x-transition.duration.300ms
					:class="open ? 'material-symbols-outlined' : 'hidden'">
					keyboard_arrow_up
				</span>
			</button>
			<ul class="rounded-md py-1 ps-8"
				x-show="open"
				x-transition.duration.300ms>
				<li>
					<a
						class="{{ request()->routeIs("home") ? "bg-blue-100 text-blue-700 dark:bg-gray-700" : "" }} flex w-full flex-row items-center justify-start gap-1 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
						href="{{ route("home") }}">
						Graph
					</a>
				</li>
				<li>
					<a
						class="{{ request()->routeIs("home") ? "bg-blue-100 text-blue-700 dark:bg-gray-700" : "" }} flex w-full flex-row items-center justify-start gap-1 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
						href="{{ route("home") }}">
						Recent Activity
					</a>
				</li>
			</ul>
		</li> --}}
		<li>
			<a
				class="{{ request()->routeIs("training-support.index") ? "bg-blue-100 text-blue-700 dark:bg-gray-700" : "" }} flex w-full flex-row items-center justify-between gap-3 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
				href="{{ route("training-support.index") }}">
				<div class="flex items-center gap-3">
					<span class="material-symbols-outlined">
						support_agent
					</span>
					<h1>
						Training & Support
					</h1>
				</div>
			</a>
		</li>
		<li>
			<a
				class="{{ request()->routeIs("users.index") ? "bg-blue-100 text-blue-700 dark:bg-gray-700" : "" }} flex w-full flex-row items-center justify-between gap-3 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
				href="{{ route("users.index") }}">
				<div class="flex items-center gap-3">
					<span class="material-symbols-outlined">
						patient_list
					</span>
					<h1>
						User Management
					</h1>
				</div>
			</a>
		</li>
		<span class="text-xs text-gray-400">PENGATURAN</span>
		<li>
			<a
				class="{{ request()->routeIs("backup.index") ? "bg-blue-100 text-blue-700 dark:bg-gray-700" : "" }} flex w-full flex-row items-center justify-between gap-3 rounded-md p-2 text-sm font-normal hover:bg-blue-100 hover:text-blue-700 dark:hover:bg-gray-700"
				href="{{ route("backupmanager") }}">
				<div class="flex items-center gap-3">
					<span class="material-symbols-outlined">
						backup
					</span>
					<h1>
						Data Backup & Recovery
					</h1>
				</div>
			</a>
		</li>
	</ul>
</aside>
