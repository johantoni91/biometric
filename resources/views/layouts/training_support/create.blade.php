@extends("layouts.app")
@section("content")
	<div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
		<form class="mb-5 flex flex-col gap-2"
			action="{{ route("training-support.store") }}"
			method="POST"
			enctype="multipart/form-data">
			@csrf
			<div>
				<label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
					for="title">Judul</label>
				<input
					class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
					id="title"
					name="title"
					type="text"
					value="{{ old("title") }}"
					placeholder="title"
					required />
				@error("title")
					<small class="text-red-500">{{ $message }}</small>
				@enderror
			</div>
			<div class="flex w-full items-center justify-center">
				<div class="mx-auto w-full max-w-md"
					x-data="singleDropzone()"
					x-on:drop.prevent="handleDrop($event)"
					x-on:dragover.prevent="dragging = true"
					x-on:dragleave.prevent="dragging = false">

					<!-- Dropzone Area -->
					<div
						class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed p-6 transition"
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
							name="file"
							type="file"
							required
							accept=".pdf,.jpg,.png,.jpeg"
							x-ref="fileInput"
							@change="handleFiles($event)">
					</div>

					<!-- Preview -->
					<div class="mt-4"
						x-show="file">
						<div class="relative">
							<!-- Gambar -->
							<template x-if="file.isImage">
								<img class="h-64 w-full rounded-lg border object-contain"
									:src="file.preview">
							</template>

							<!-- PDF, DOCX, dll. -->
							<template x-if="!file.isImage">
								<iframe class="h-64 w-full rounded-lg border"
									:src="file.preview"></iframe>
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
			@error("file")
				<small class="text-red-500">{{ $message }}</small>
			@enderror

			<div class="flex items-center justify-end">
				<button
					class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
