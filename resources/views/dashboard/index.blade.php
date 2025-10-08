@extends("layouts.app")
@section("content")
	<div class="grid grid-cols-12 gap-3">
		<div class="col-span-12 xl:col-span-7">
			<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
				<div
					class="flex flex-col items-start justify-start gap-6 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-800/30">
					<span class="material-symbols-outlined rounded-xl bg-gray-100 p-2 dark:bg-gray-800">
						groups
					</span>
					<div class="flex w-full flex-row items-end justify-between">
						<div>
							<h1 class="text-gray-400">Users</h1>
							<p class="text-xl font-bold">5</p>
						</div>
						<span class="rounded-full bg-blue-200/50 p-2 text-xs font-semibold text-blue-500 dark:bg-blue-600/10">February
							2025</span>
					</div>
				</div>
				<div
					class="flex flex-col items-start justify-start gap-6 rounded-xl border border-gray-200 bg-white p-3 dark:border-gray-800 dark:bg-gray-800/30">
					<span class="material-symbols-outlined rounded-xl bg-gray-100 p-2 dark:bg-gray-800">
						history_edu
					</span>
					<div class="flex w-full flex-row items-end justify-between">
						<div>
							<h1 class="text-gray-400">Activity</h1>
							<p class="text-xl font-bold">100</p>
						</div>
						<span class="rounded-full bg-blue-200/50 p-2 text-xs font-semibold text-blue-500 dark:bg-blue-600/10">February
							2025</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-span-12 xl:col-span-5">
			<div
				class="relative max-h-64 overflow-y-scroll rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-800/30">
				<h1
					class="sticky top-0 mb-5 border-b bg-white px-4 py-3 text-lg font-semibold dark:border-gray-800 dark:bg-gray-800">
					Aktivitas Terbaru</h1>
				<ul class="px-5">
					@for ($i = 0; $i < 5; $i++)
						<li class="mb-4 flex items-center justify-between border-b pb-4 dark:border-gray-700">
							<div class="flex items-center gap-2">
								<img class="self-start rounded-full"
									src="{{ asset("images/monkey.jpeg") }}"
									alt=""
									width="30"
									height="30">
								<div class="flex flex-col items-start justify-start gap-2 break-words">
									<h1 class="text-sm font-light text-gray-400">Test</h1>
									<p class="text-xs font-thin">Lorem ipsum dolor sit, amet consectetur ...</p>
								</div>
							</div>
							<p class="text-sm font-light text-gray-400">1 min ago</p>
						</li>
					@endfor
				</ul>
			</div>
		</div>
	</div>
@endsection
