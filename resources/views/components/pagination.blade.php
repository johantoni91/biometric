<nav class="flex-column flex flex-wrap items-center justify-between p-4 md:flex-row"
	aria-label="Table navigation">
	<span
		class="mb-4 block w-full text-sm font-normal text-gray-500 dark:text-gray-400 md:mb-0 md:inline md:w-auto">Menampilkan
		<span class="font-semibold text-gray-900 dark:text-white">{{ $data["from"] }}-{{ $data["to"] }}</span>
		dari
		<span class="font-semibold text-gray-900 dark:text-white">{{ $data["total"] }}</span>
		data</span>
	@if (reset($data["links"])["url"] != null || end($data["links"])["url"] != null)
		<ul class="inline-flex h-8 -space-x-px text-sm rtl:space-x-reverse">
			@if ($data["prev_page_url"])
				<li>
					<a
						class="ms-0 flex h-8 items-center justify-center rounded-s-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
						href="{{ route("pagination", [$view, encrypt($data["first_page_url"])]) }}">
						<< </a>
				</li>
				<li>
					<a
						class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
						href="{{ route("pagination", [$view, encrypt($data["prev_page_url"])]) }}">
						< </a>
				</li>
			@endif
			<li
				class="flex h-8 items-center justify-center border border-gray-300 bg-blue-50 px-3 text-blue-600 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
				{{ $data["current_page"] }}
			</li>
			@if ($data["next_page_url"])
				<li>
					<a
						class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
						href="{{ route("pagination", [$view, encrypt($data["next_page_url"])]) }}">
						> </a>
				</li>
				<li>
					<a
						class="flex h-8 items-center justify-center rounded-e-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
						href="{{ route("pagination", [$view, encrypt($data["last_page_url"])]) }}">
						>> </a>
				</li>
			@endif
		</ul>
	@endif
</nav>
