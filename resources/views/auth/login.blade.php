@extends("layouts.auth")
@section("auth")
	<h1 class="mb-5 text-xl font-bold">Masuk</h1>
	<form class="flex flex-col gap-4"
		method="POST"
		action="{{ route("login.post") }}">
		@csrf
		<div class="flex flex-col gap-1">
			<label class="mb-2"
				for="nip">NIP <span class="text-red-500">*</span></label>
			<input class="w-full rounded-lg border border-gray-300 py-3 text-xs"
				id="nip"
				name="nip"
				type="number"
				placeholder="Masukkan NIP anda">
		</div>
		<div class="relative flex flex-col gap-1">
			<label for="password">Password <span class="text-red-500">*</span></label>
			<input class="w-full rounded-lg border border-gray-300 py-3 text-xs"
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
			<label class="mb-2"
				for="captcha">Captcha <span class="text-red-500">*</span></label>
			<input class="w-full rounded-lg border border-gray-300 py-3 text-xs"
				id="captcha"
				name="captcha"
				type="text">
			<img class="mt-2"
				class="h-auto object-cover"
				src="{{ captcha_src("math") }}"
				width="300">
		</div>
		<button class="w-full rounded-lg bg-blue-500 py-2 text-center text-white"
			type="submit">Masuk</button>
	</form>
@endsection
