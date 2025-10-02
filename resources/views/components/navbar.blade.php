<nav
	class="relative flex w-full items-center justify-between border-b border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
	x-data="{ profile: false }">
	<button class="px-1 pt-1 dark:border-gray-700"
		@click="sidebar = !sidebar">
		<span class="material-symbols-outlined">
			sort
		</span>
	</button>
	<div class="flex items-center justify-end gap-3">
		<x-toggle />
		<button class="text-sm hover:animate-pulse dark:text-white"
			type="button">
			<span class="material-symbols-outlined">
				notifications
			</span>
		</button>
		<button class="flex items-center justify-between gap-5"
			@click="profile = !profile">
			<div class="flex items-center">
				<img class="rounded-full border-gray-300 p-2 dark:border-gray-800"
					src="{{ auth()->user()->photo ? asset("storage/" . auth()->user()->photo) : asset("images/logo.png") }}"
					alt=""
					width="50"
					height="50">
				<h1>{{ auth()->user()->name }}</h1>
			</div>
			<span x-transition.duration.300ms
				:class="profile ? 'hidden' : 'material-symbols-outlined'">
				keyboard_arrow_down
			</span>
			<span x-transition.duration.300ms
				:class="profile ? 'material-symbols-outlined' : 'hidden'">
				keyboard_arrow_up
			</span>
		</button>
	</div>
	<div
		class="w-42 absolute right-2 top-[5.3rem] z-50 flex flex-col items-start justify-start gap-5 overflow-hidden rounded-xl bg-white px-3 py-5 text-sm text-gray-500 dark:bg-gray-800 dark:text-gray-400"
		x-show="profile">
		<ul class="overflow-hidden border-b border-gray-200 pb-3 dark:border-gray-700">
			<p class="truncate">{{ auth()->user()->name }}</p>
			<p class="font-thin">{{ auth()->user()->nip }}</p>
		</ul>
		<ul class="flex flex-col gap-5">
			<li>
				<a class="flex items-center gap-1"
					href="{{ route("profile") }}">
					<span class="material-symbols-outlined">
						account_circle
					</span>
					Edit Profile
				</a>
			</li>
			<li>
				<a class="flex items-center gap-1"
					href="{{ route("logout") }}">
					<span class="material-symbols-outlined">
						logout
					</span>
					Logout
				</a>
			</li>
		</ul>
	</div>
</nav>
