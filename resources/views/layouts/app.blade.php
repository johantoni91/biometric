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

		{{-- flowbite --}}
		<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
			rel="stylesheet" />
		<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

		{{-- Sweetalert2 --}}
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.23.0/dist/sweetalert2.all.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.23.0/dist/sweetalert2.min.css"
			rel="stylesheet">

		{{-- Alpine js --}}
		<script defer
			src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
		<script defer
			src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

		{{-- Jquery --}}
		<script src="{{ asset("assets/js/jquery-3.7.1.min.js") }}"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		{{-- Toggle theme Darklight --}}
		<script>
			if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
					'(prefers-color-scheme: dark)').matches)) {
				document.documentElement.classList.add('dark');
			} else {
				document.documentElement.classList.remove('dark')
			}
		</script>
		@stack("styles")
	</head>

	<body class="h-screen w-screen bg-gray-100 dark:bg-gray-900 dark:text-white"
		x-data="{ sidebar: $persist(true) }">
		@include("sweetalert::alert")
		<div class="relative h-screen w-screen md:flex"
			x-data="{
    width: window.innerWidth,
    updateWidth() { this.width = window.innerWidth }
}"
			x-init="window.addEventListener('resize', () => updateWidth())">
			<x-sidebar />
			<div class="flex h-full flex-col"
				:class="sidebar ? 'w-screen overflow-hidden' : 'w-full'">
				<x-navbar />
				<main class="relative h-full w-full overflow-x-hidden overflow-y-scroll bg-gray-100 p-5 dark:bg-gray-900">
					<x-breadcrumb />
					@yield("content")
				</main>
				<footer class="sticky bottom-0 flex w-full items-center justify-center bg-white p-4 dark:bg-gray-800">
					<p class="text-sm text-gray-500 dark:text-gray-400">© 2025 Biometric</p>
				</footer>
			</div>
		</div>
		<script>
			function singleDropzone() {
				return {
					file: null,
					dragging: false,

					handleFiles(e) {
						const uploadedFile = e.target.files[0];
						if (!uploadedFile) return;

						this.setFile(uploadedFile);
					},

					handleDrop(e) {
						const droppedFile = e.dataTransfer.files[0];
						if (!droppedFile) return;

						this.setFile(droppedFile);
						this.dragging = false;
					},

					setFile(uploadedFile) {
						const isImage = uploadedFile.type.startsWith("image/");
						const previewUrl = URL.createObjectURL(uploadedFile);

						this.file = {
							name: uploadedFile.name,
							type: uploadedFile.type,
							isImage,
							preview: previewUrl
						};
					},

					removeFile() {
						this.file = null;
						this.$refs.fileInput.value = "";
					}
				}
			}
		</script>
		@stack("scripts")
	</body>

</html>
