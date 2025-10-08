@extends("layouts.app")
@section("content")
	<div class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
		<form id="frmNew"
			action="{{ route("backupmanager_create") }}"
			method="POST">
			@csrf
			<button
				class="rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
				type="submit">Backup</button>
		</form>

		<form class="h-full rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
			id="frm"
			action="{{ route("backupmanager_restore_delete") }}"
			method="post">
			@csrf
			<div class="relative mb-5 overflow-x-auto shadow-md sm:rounded-lg">
				<table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
					<thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
						<tr>
							<th class="px-6 py-3"
								scope="col">
								#
							</th>
							<th class="px-6 py-3"
								scope="col">
								Nama
							</th>
							<th class="px-6 py-3"
								scope="col">
								Ukuran
							</th>
							<th class="px-6 py-3"
								scope="col">
								Tanggal
							</th>
							<th class="px-6 py-3"
								scope="col">
								Kondisi
							</th>
							<th class="px-6 py-3"
								scope="col">
								Tipe
							</th>
							<th class="px-6 py-3"
								scope="col">
								Unduh
							</th>
							<th class="px-6 py-3 text-center"
								scope="col">
								Aksi
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($backups as $index => $backup)
							<tr
								class="border-b border-gray-200 bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
								<td class="px-6 py-4">
									{{ ++$index }}
								</td>
								<td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
									scope="row">
									{{ $backup["name"] }}
								</td>
								<td class="px-6 py-4">
									{{ $backup["size"] }}
								</td>
								<td class="px-6 py-4">
									{{ $backup["date"] }}
								</td>
								<td class="px-6 py-4">
									<?php
									$okSizeBytes = 1024;
									$isOk = $backup["size_raw"] >= $okSizeBytes;
									$text = $isOk ? "Baik" : "Buruk";
									$icon = $isOk ? "green" : "red";
									
									echo "<span class='bg-$icon-500 p-3 rounded-lg text-white'>$text</span>";
									?>
								</td>
								<td class="px-6 py-4">
									<span
										class="col-sm-8 badge badge-{{ $backup["type"] === "Files" ? "primary" : "success" }}">{{ $backup["type"] }}</span>
								</td>
								<td class="px-6 py-4">
									<a
										class="flex items-center justify-center gap-3 rounded-lg bg-green-500 p-2 font-light text-white hover:bg-green-600 dark:bg-green-700 dark:hover:bg-green-600"
										href="{{ route("backupmanager_download", $backup["name"]) }}"
										target="_blank">
										<span class="material-symbols-outlined">
											download
										</span>
										Unduh
									</a>
								</td>
								<td class="px-6 py-4">
									<input class="chkBackup"
										name="backups[]"
										type="checkbox"
										value="{{ $backup["name"] }}">
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@if (count($backups))
				<input id="type"
					name="type"
					type="hidden"
					value="restore">

				<div class="flex items-center justify-end gap-4">
					<button
						class="flex items-center justify-center gap-2 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
						id="btnSubmit"
						type="submit"
						disabled="disabled">
						<span class="material-symbols-outlined">
							cached
						</span>
						Pulihkan</button>
					<button
						class="flex items-center justify-center gap-2 rounded-lg bg-red-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
						id="btnDelete"
						type="submit"
						disabled="disabled">
						<span class="material-symbols-outlined">
							delete
						</span>
						Hapus</button>
				</div>
			@endif
		</form>
		<div id="overlay">
			<div class="spinner"></div>
			<span class="overlay-message">Harap tunggu...</span>
		</div>
	</div>
@endsection
@push("styles")
	<style>
		#overlay {
			position: fixed;
			display: none;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: rgba(0, 0, 0, 0.7);
			z-index: 9999999999;
		}

		#overlay .overlay-message {
			position: fixed;
			left: 50%;
			top: 57%;
			height: 100px;
			width: 250px;
			margin-left: -120px;
			margin-top: -50px;
			color: #fff;
			font-size: 20px;
			text-align: center;
			font-weight: bold;
		}

		.spinner {
			position: fixed;
			left: 50%;
			top: 40%;
			height: 80px;
			width: 80px;
			margin-left: -40px;
			margin-top: -40px;
			-webkit-animation: rotation .9s infinite linear;
			-moz-animation: rotation .9s infinite linear;
			-o-animation: rotation .9s infinite linear;
			animation: rotation .9s infinite linear;
			border: 6px solid rgba(255, 255, 255, .15);
			border-top-color: rgba(255, 255, 255, .8);
			border-radius: 100%;
		}

		@-webkit-keyframes rotation {
			from {
				-webkit-transform: rotate(0deg);
			}

			to {
				-webkit-transform: rotate(359deg);
			}
		}

		@-moz-keyframes rotation {
			from {
				-moz-transform: rotate(0deg);
			}

			to {
				-moz-transform: rotate(359deg);
			}
		}

		@-o-keyframes rotation {
			from {
				-o-transform: rotate(0deg);
			}

			to {
				-o-transform: rotate(359deg);
			}
		}

		@keyframes rotation {
			from {
				transform: rotate(0deg);
			}

			to {
				transform: rotate(359deg);
			}
		}

		table.dataTable tr.group td {
			background-image: radial-gradient(#fff, #eee);
			border: none;
			text-align: center;
			font-weight: bold;
			font-size: 16px;
		}
	</style>

	@push("scripts")
		<script>
			var $btnSubmit = $('#btnSubmit');
			var $btnDelete = $('#btnDelete');
			var $type = $('#type');
			var type = 'restore';

			$btnSubmit.on('click', function() {
				$type.val('restore');
				type = 'restore';
			});

			$btnDelete.on('click', function() {
				$type.val('delete');
				type = 'delete';
			});

			$(document).on('click', '.chkBackup', function() {
				var checkedCount = $('.chkBackup:checked').length;
				if (checkedCount > 0) {
					$btnSubmit.attr('disabled', false);
					$btnDelete.attr('disabled', false);
				} else {
					$btnSubmit.attr('disabled', true);
					$btnDelete.attr('disabled', true);
				}

				if (this.checked) {
					$(this).closest('tr').addClass('warning');
				} else {
					$(this).closest('tr').removeClass('warning');
				}
			});

			$('#frm').submit(function() {
				var $this = this;
				var checkedCount = $('.chkBackup:checked').length;
				var $btn = $('#btnSubmit');

				if (!checkedCount) {
					swal("Mohon pilih data backup terlebih dahulu!");
					return false;
				}

				if (checkedCount > 2 && type === 'restore') {
					swal("Mohon pilih 1 atau maksimal 2 data sekaligus.");
					return false;
				}

				var msg = 'Lanjutkan proses pemulihan ?';

				if (type === 'delete') {
					msg = 'Apa kamu yakin mau menghapus data backup(s) ?';
				}

				swal({
					title: "Confirm",
					text: msg,
					icon: "warning",
					buttons: true,
					dangerMode: true
				}).then(function(response) {
					if (response) {
						$btn.attr('disabled', true);

						$this.submit();
						showOverlay();
					}
				});

				return false;
			});

			$('#frmNew').submit(function() {
				this.submit();
				showOverlay();
			});

			function showOverlay() {
				$('#overlay').show();
			}

			function hideOverlay() {
				$('#overlay').show();
			}
		</script>
	@endpush
