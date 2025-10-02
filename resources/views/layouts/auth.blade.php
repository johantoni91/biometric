<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
			content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible"
			content="ie=edge">
		<title>{{ config("app.name") }}</title>
		@vite(["resources/css/app.css", "resources/js/app.js"])

		{{-- Material icons & Fonts --}}
		<link href="https://fonts.googleapis.com"
			rel="preconnect">
		<link href="https://fonts.gstatic.com"
			rel="preconnect"
			crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap"
			rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
			rel="stylesheet" />

		{{-- Alpine js --}}
		<script src="//unpkg.com/alpinejs"
			defer></script>

		{{-- Chart --}}
		<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>

		{{-- Toggle theme Darklight --}}
		<script>
			if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
					'(prefers-color-scheme: dark)').matches)) {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark')
			}
		</script>
	</head>

	<body class="outfit relative h-screen w-screen bg-gray-100 text-sm font-thin dark:bg-gray-900 dark:text-white">
		<main class="grid h-full w-full grid-cols-12">
			<div class="col-span-12 m-auto w-full px-12 lg:col-span-6">
				@yield("auth")
			</div>
			<div class="hidden lg:col-span-6 lg:block">
				<img class="object-fit h-full w-full"
					src="{{ asset("images/bg.jpg") }}"
					alt="">
			</div>
		</main>
		<div class="absolute bottom-4 right-4">
			<x-toggle />
		</div>
	</body>
	<script src="https://unpkg.com/flowbite@1.3.4/dist/flowbite.js"></script>

</html>
