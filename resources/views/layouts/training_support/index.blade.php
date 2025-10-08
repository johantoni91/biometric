@extends("layouts.app")
@section("content")
	<div class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
		<div>
			<x-link url='{{ route("training-support.create") }}'
				label='+ Tambah' />
		</div>
		<div class="flex items-center justify-center gap-5">
			<x-input id="Judul"
				placeholder="Judul" />

			<input
				class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
				id="judul"
				type="text"
				placeholder="Judul" />

			<button
				class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
				type="submit">Cari</button>

		</div>

		<div class="h-full rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">

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
								Cover
							</th>
							<th class="px-6 py-3"
								scope="col">
								Judul
							</th>
							<th class="px-6 py-3 text-center"
								scope="col">
								Aksi
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $i => $item)
							<tr
								class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
								<th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
									scope="row">
									{{ $data->firstItem() + $i }}
								</th>
								<td class="px-6 py-4">
									<embed class="h-24 w-24 rounded-lg object-cover"
										src="{{ asset("storage/" . $item->content) }}">
								</td>
								<td class="px-6 py-4">
									{{ $item->title }}
								</td>
								<td class="px-6 py-4">
									<div class="flex items-center justify-center gap-2 align-middle">
										<a
											class="flex items-center justify-center gap-3 rounded-lg bg-green-500 p-2 font-light text-white hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600"
											href="{{ asset("storage/" . $item->content) }}"
											target="_blank">
											<span class="material-symbols-outlined">
												frame_inspect
											</span>
											Pratinjau
										</a>
										<a
											class="flex items-center justify-center gap-3 rounded-lg bg-blue-500 p-2 font-light text-white hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600"
											href="{{ route("training-support.edit", Hashids::encode((string) $item["id"])) }}">
											<span class="material-symbols-outlined">
												edit
											</span>
											Ubah
										</a>
										<button
											class="flex items-center justify-center gap-3 rounded-lg bg-red-500 p-2 font-light text-white hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-600"
											id='delete-item-{{ $item["id"] }}'
											type="button">
											<span class="material-symbols-outlined">
												delete
											</span>
											Hapus
										</button>

										<form id="delete-form-{{ $item["id"] }}"
											style="display: none;"
											action="{{ route("training-support.destroy", $item["id"]) }}"
											method="POST">
											@csrf
											@method("DELETE")
										</form>
										<script>
											$('#delete-item-{{ $item["id"] }}').click(function() {
												Swal.fire({
													title: "Hapus Dokumen",
													text: "Anda yakin hapus dokumen?",
													icon: "error",
													showCancelButton: true,
													cancelButtonText: "Batal",
													confirmButtonColor: "#d33",
													cancelButtonColor: "#3085d6",
													confirmButtonText: "Ya"
												}).then((result) => {
													if (result.isConfirmed) {
														$("#delete-form-{{ $item["id"] }}").submit();
													}
												});
											});
										</script>
									</div>
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
