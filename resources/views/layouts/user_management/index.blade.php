@extends("layouts.app")
@section("content")
	<div class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
		<div>
			<x-link url='{{ route("users.create") }}'
				label='+ Tambah User' />
		</div>
		<form class="flex items-center justify-center gap-5"
			action="{{ route("users.search") }}"
			method="GET">
			<input
				class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
				id="name"
				name="name"
				type="text"
				value="{{ request("name") }}"
				placeholder="Nama" />
			<input
				class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
				id="email"
				name="email"
				type="text"
				value="{{ request("email") }}"
				placeholder="Email" />
			<input
				class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
				id="nip"
				name="nip"
				type="number"
				value="{{ request("nip") }}"
				placeholder="NIP" />
			<input
				class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
				id="satker"
				name="satker"
				type="text"
				value="{{ request("satker") }}"
				placeholder="Satker" />
			<button
				class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
				type="submit">Cari</button>
		</form>
		<div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">

			<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
				<table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
					<thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th class="px-6 py-3"
								scope="col">
								No
							</th>
							<th class="px-6 py-3"
								scope="col">
								Nama
							</th>
							<th class="px-6 py-3"
								scope="col">
								Email
							</th>
							<th class="px-6 py-3"
								scope="col">
								NIP
							</th>
							<th class="px-6 py-3"
								scope="col">
								Satker
							</th>
							<th class="px-6 py-3"
								scope="col">
								Role
							</th>
							<th class="px-6 py-3 text-center"
								scope="col">
								Aksi
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $i => $user)
							<tr
								class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
								<th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
									scope="row">
									{{ $data->firstItem() + $i }}
								</th>
								<td class="px-6 py-4">
									<div class="flex items-center justify-start gap-3">
										<img class="h-10 w-10 rounded-lg"
											src="{{ $user->photo ? asset("storage/" . $user->photo) : asset("images/logo.png") }}"
											alt=""
											width="40"
											height="40">
										{{ $user->name }}
									</div>
								</td>
								<td class="px-6 py-4">
									{{ $user->email }}
								</td>
								<td class="px-6 py-4">
									{{ $user->nip }}
								</td>
								<td class="px-6 py-4">
									{{ $user->satker }}
								</td>
								<td class="px-6 py-4">
									{{ $user->role }}
								</td>
								<td class="flex items-center justify-center gap-2 px-6 py-4">
									<a
										class="flex items-center justify-center gap-3 rounded-lg bg-blue-500 p-2 font-light text-white hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600"
										href="{{ $user->id == auth()->user()->id ? route("profile") : route("users.edit", Hashids::encode((string) $user["id"])) }}">
										<span class="material-symbols-outlined">
											edit
										</span>
										Ubah
									</a>
									<button
										class="flex items-center justify-center gap-3 rounded-lg bg-red-500 p-2 font-light text-white hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-600"
										id="delete-user-{{ $user["id"] }}"
										type="button">
										<span class="material-symbols-outlined">
											delete
										</span>
										Hapus
									</button>

									<form id="delete-form-{{ $user["id"] }}"
										style="display: none;"
										action="{{ route("users.destroy", $user["id"]) }}"
										method="POST">
										@csrf
										@method("DELETE")
									</form>
									<script>
										$("#delete-user-{{ $user["id"] }}").click(function() {
											Swal.fire({
												title: "Hapus user",
												text: "Anda yakin hapus {{ $user["name"] }} ?",
												icon: "error",
												showCancelButton: true,
												cancelButtonText: "Batal",
												confirmButtonColor: "#d33",
												cancelButtonColor: "#3085d6",
												confirmButtonText: "Ya"
											}).then((result) => {
												if (result.isConfirmed) {
													$("#delete-form-{{ $user["id"] }}").submit();
												}
											});
										});
									</script>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="mt-3">
				{{ $data->links() }}
			</div>
		</div>
	</div>
@endsection
