@php
	$segments = request()->segments();
@endphp

<nav class="mb-5 flex"
	aria-label="Breadcrumb">
	<ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
		@foreach ($segments as $i => $segment)
			<li class="inline-flex items-center gap-2">
				@if ($i < count($segments) - 1)
					<a
						class="inline-flex items-center text-sm font-medium capitalize text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
						href="{{ url(implode("/", array_slice($segments, 0, $i + 1))) }}">
						<span class="material-symbols-outlined">
							support_agent
						</span>
						{{ $segment }}
					</a>
					<svg class="mx-1 h-3 w-3 text-gray-400 rtl:rotate-180"
						aria-hidden="true"
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 6 10">
						<path stroke="currentColor"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="m1 9 4-4-4-4" />
					@else
						<span class="capitalize text-gray-400 dark:text-gray-500">{{ $segment }}</span>
				@endif
			</li>
		@endforeach
	</ol>
</nav>
