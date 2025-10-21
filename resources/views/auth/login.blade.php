@extends("layouts.auth")
@section("auth")
	<div
		class="h-full w-full grid-cols-8 bg-slate-50 p-5 dark:bg-slate-400 dark:text-black dark:shadow-blue-500 md:grid md:h-[70dvh] md:w-[80dvw] md:rounded-lg md:shadow-lg md:shadow-blue-400 lg:w-[70dvw] xl:w-[60dvw]">
		<div class="col-span-4 rounded-lg md:h-full">
			<img class="object-fit h-[35dvh] w-full rounded-lg md:h-full"
				src="{{ asset("images/24972.jpg") }}"
				alt="">
		</div>
		<div class="col-span-4 mt-5 flex flex-col gap-6 px-10 py-5">
			<div>
				<h1 class="text-2xl font-bold">Masuk</h1>
				<p class="">Masukkan NIP dan password anda</p>
			</div>

			<form class="flex flex-col gap-4"
				method="POST"
				action="{{ route("login.post") }}">
				@csrf
				<div class="flex flex-col gap-1">
					<label class="mb-2 text-lg font-bold"
						for="nip">NIP <span class="text-red-500">*</span></label>
					<input class="w-full rounded-lg border border-gray-400 py-3"
						id="nip"
						name="nip"
						type="number"
						placeholder="Masukkan NIP anda">
				</div>
				<div class="relative flex flex-col gap-1">
					<label class="text-lg font-bold"
						for="password">Password <span class="text-red-500">*</span></label>
					<input class="w-full rounded-lg border border-gray-400 py-3"
						id="password"
						name="password"
						type="password"
						value="password"
						placeholder="Masukkan password">
					<button class="absolute bottom-0.5 right-2 text-gray-500">
						<span class="material-symbols-outlined"
							x-text="icon"
							@click="togglePass()">
						</span>
					</button>
				</div>
				<div class="flex flex-col gap-1">
					<label class="mb-2 text-lg font-bold"
						for="captcha">Captcha <span class="text-red-500">*</span></label>
					<input class="w-full rounded-lg border border-gray-400 py-3"
						id="captcha"
						name="captcha"
						type="text">
					<div class="captcha-container flex items-center gap-4">
						<img id="captcha-image"
							src="{{ captcha_src("flat") }}"
							alt="captcha">
						<button class="rounded-full bg-blue-500 px-2 pt-1 text-white dark:text-black"
							id="refresh-captcha"
							type="button">
							<span class="material-symbols-outlined"
								x-text="icon">
								refresh
							</span>
						</button>
					</div>
				</div>
				<button class="w-full rounded-lg bg-blue-500 py-2 text-center text-white"
					type="submit">Masuk</button>
			</form>
		</div>

	</div>
	<script>
		document.getElementById('refresh-captcha').addEventListener('click', function() {
			fetch('/refresh-captcha')
				.then(response => response.json())
				.then(data => {
					document.getElementById('captcha-image').src =
						data.captcha.match(/src="([^"]+)"/)[1];
				});
		});
	</script>
@endsection
