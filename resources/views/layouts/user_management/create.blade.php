@extends("layouts.app")
@section("content")
	<div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
		<form action="{{ route("users.store") }}"
			method="POST"
			enctype="multipart/form-data">
			@csrf

			<div class="w-full">
				<label class="mb-3 block text-sm font-medium text-gray-900 dark:text-white"
					for="file">Foto User</label>
				<div class="flex w-full items-center justify-around"
					x-data="singleDropzone()"
					x-on:drop.prevent="handleDrop($event)"
					x-on:dragover.prevent="dragging = true"
					x-on:dragleave.prevent="dragging = false">

					<!-- Dropzone Area -->
					<div
						class="col-span-4 flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed p-6 transition"
						:class="dragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300 bg-gray-50 hover:bg-gray-100'"
						@click="$refs.fileInput.click()">

						<svg class="mb-3 h-12 w-12 text-gray-400"
							fill="none"
							stroke="currentColor"
							viewBox="0 0 24 24">
							<path stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M7 16V4m0 0l4 4m-4-4L3 8m13 8v4m0 0h4m-4 0H9" />
						</svg>

						<p class="text-gray-600"
							x-show="!file">Drag & Drop file di sini atau klik untuk memilih</p>
						<input class="hidden"
							id="file"
							name="photo"
							type="file"
							required
							accept=".jpg,.png,.jpeg"
							x-ref="fileInput"
							@change="handleFiles($event)">
					</div>

					<!-- Preview -->
					<div class="col-span-8 mt-4"
						x-show="file">
						<div class="relative">
							<!-- Gambar -->
							<template x-if="file.isImage">
								<img class="h-64 w-full rounded-lg border object-contain"
									:src="file.preview">
							</template>

							<!-- Tombol hapus -->
							<button
								class="absolute -right-3 -top-3 flex h-7 w-7 items-center justify-center rounded-full bg-red-500 text-white shadow"
								type="button"
								@click="removeFile()">✕</button>
						</div>
					</div>
				</div>
			</div>
			@error("photo")
				<small class="text-red-500">{{ $message }}</small>
			@enderror

			<div class="my-5 grid grid-cols-12 gap-2">
				<div class="col-span-3">
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="name">Nama</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						id="name"
						name="name"
						type="text"
						value="{{ old("name") }}"
						placeholder="Nama"
						required />
					@error("name")
						<small class="text-red-500">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-span-3">
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="nip">NIP</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						id="nip"
						name="nip"
						type="number"
						value="{{ old("nip") }}"
						required />
					@error("nip")
						<small class="text-red-500">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-span-3">
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="satker">Satker</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						id="satker"
						name="satker"
						type="text"
						value="{{ old("satker") }}"
						placeholder="Satker"
						required />
					@error("satker")
						<small class="text-red-500">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-span-3">
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="Roles">Roles</label>
					<select
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						id="Roles"
						name="role">
						<option selected>-- Roles --</option>
						<option value="superadmin"
							{{ old("role") == "superadmin" ? "selected" : "" }}>Superadmin</option>
						<option value="admin"
							{{ old("role") == "admin" ? "selected" : "" }}>Admin</option>
						<option value="pegawai"
							{{ old("role") == "pegawai" ? "selected" : "" }}>Pegawai</option>
					</select>
					@error("role")
						<small class="text-red-500">{{ $message }}</small>
					@enderror
				</div>
			</div>

			<div class="grid grid-cols-12 gap-4">
				<div class="col-span-6">
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="email">Email</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						id="email"
						name="email"
						type="email"
						value="{{ old("email") }}"
						placeholder="Email"
						required />
					@error("email")
						<small class="text-red-500">{{ $message }}</small>
					@enderror
				</div>
				<div class="col-span-6">
					<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
						for="password">Your password</label>
					<input
						class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
						id="password"
						name="password"
						type="password"
						required />
					@error("password")
						<small class="text-red-500">{{ $message }}</small>
					@enderror
				</div>
			</div>

			<div>
				<x-link class="mt-6"
					url='{{ route("users.index") }}'
					label="Kembali" />
				<button
					class="mt-6 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
					type="submit">Tambah</button>
			</div>
		</form>
	</div>
	@if ($errors->any())
		<div class="absolute bottom-5 right-5 z-50">
			@foreach ($errors->all() as $error)
				<div class="mb-4 flex items-center rounded-lg bg-red-50 p-4 text-red-800 dark:bg-gray-800 dark:text-red-400"
					id="alert-2"
					role="alert">
					<svg class="h-4 w-4 shrink-0"
						aria-hidden="true"
						xmlns="http://www.w3.org/2000/svg"
						fill="currentColor"
						viewBox="0 0 20 20">
						<path
							d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
					</svg>
					<span class="sr-only">Info</span>
					<div class="mx-3 text-sm font-medium">
						{{ $error }}
					</div>
					<button
						class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 p-1.5 text-red-500 hover:bg-red-200 focus:ring-2 focus:ring-red-400 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
						data-dismiss-target="#alert-2"
						type="button"
						aria-label="Close">
						<span class="sr-only">Close</span>
						<svg class="h-3 w-3"
							aria-hidden="true"
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 14 14">
							<path stroke="currentColor"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
						</svg>
					</button>
				</div>
			@endforeach
		</div>
	@endif
@endsection
