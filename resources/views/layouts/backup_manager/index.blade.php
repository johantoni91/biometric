@extends("layouts.app")
@section("content")
	<div class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
		<form action="{{ route("backup.create") }}"
			method="POST">
			@csrf
			<x-button label="Backup" />
		</form>

		<div class="h-full rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">

			<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
				<table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
					<thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th class="px-6 py-3"
								scope="col">
								Nama File
							</th>
							<th class="px-6 py-3"
								scope="col">
								Ukuran
							</th>
							<th class="px-6 py-3"
								scope="col">
								Tanggal
							</th>
							<th class="px-6 py-3 text-center"
								scope="col">
								Aksi
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($backups as $backup)
							<tr
								class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
								<th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
									scope="row">
									{{ $backup["file_name"] }}
								</th>
								<td class="px-6 py-4">
									{{ $backup["size"] }} KB
								</td>
								<td class="px-6 py-4">
									{{ $backup["date"] }}
								</td>
								<td class="px-6 py-4">
									<div class="flex items-center justify-center gap-2 align-middle">
										<a
											class="flex items-center justify-center gap-3 rounded-lg bg-green-500 p-2 font-light text-white hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600"
											href="{{ route("backup.download", $backup["file_name"]) }}"
											target="_blank">
											<span class="material-symbols-outlined">
												download
											</span>
											Unduh
										</a>
										<form action="{{ route("backup.restore", $backup["file_name"]) }}"
											method="POST">
											@csrf
											<button
												class="flex items-center justify-center gap-3 rounded-lg bg-blue-500 p-2 font-light text-white hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600">
												<span class="material-symbols-outlined">
													restore_page
												</span> Pulihkan</button>
										</form>
										<form action="{{ route("backup.destroy", $backup["file_name"]) }}"
											method="POST">
											@csrf @method("DELETE")
											<button
												class="flex items-center justify-center gap-3 rounded-lg bg-red-500 p-2 font-light text-white hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-600"><span
													class="material-symbols-outlined">
													delete
												</span> Hapus</button>
										</form>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
