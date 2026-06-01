<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>WelcomePageUserBELUMLOGIN</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<style>
		body {
			font-family: 'Plus Jakarta Sans', sans-serif;
		}
	</style>
</head>
<body>
		<div class="flex flex-col bg-white">
		<div class="self-stretch bg-[#E1F5FE] pb-[368px]">
			<div class="flex flex-col items-start self-stretch relative">
				<div class="self-stretch bg-[#E1F5FE] pt-[18px]">
					<div class="flex items-center self-stretch mb-[118px] ml-[52px] mr-[31px]">
						<img
							src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/j2s379y9_expires_30_days.png" 
							class="w-[152px] h-[55px] object-fill"
						/>
						<div class="flex-1 self-stretch">
						</div>
						<a href="{{ route('user.services.index') }}" class="text-black text-base font-bold mr-11 hover:text-[#1E8593] transition-colors {{ request()->routeIs('user.services.*') ? 'underline' : '' }}">Cari Mitra</a>
						
						<a href="{{ route('user.orders.history') }}" class="text-black text-base font-bold mr-[42px] hover:text-[#1E8593] transition-colors {{ request()->routeIs('user.orders.*') ? 'underline' : '' }}">Riwayat</a>
						
						<a href="#" class="text-black text-base font-bold mr-8 hover:text-[#1E8593] transition-colors">Profil</a>
						
						<span class="text-black text-base font-bold mr-11">
							Tentang kami
						</span>
						<div class="flex-1 self-stretch">
						</div>
						<a href="{{ route('login') }}" class="flex flex-col shrink-0 items-center justify-center bg-[#FFFFFF9E] text-black text-base font-bold py-5 px-[35px] mr-2 rounded-[100px] no-underline">
							<span class="text-black text-base font-bold" >
								Masuk
							</span>
						</a>
						<a href="{{ route('register') }}" class="flex flex-col shrink-0 items-center justify-center bg-[#B6E8FE9E] text-black text-base font-bold py-2.5 px-9 rounded-[17px] no-underline">
							<span class="text-black text-base font-bold" >
								Daftar
							</span>
						</a>
					</div>
					<div class="flex flex-col items-center self-stretch mb-[29px]">
						<span class="text-[#1A202C] text-[64px] font-bold" >
							Cari Mitra Jasa Terpecaya
						</span>
					</div>
					<div class="flex flex-col items-center self-stretch mb-[68px]">
						<span class="max-w-[824px] w-full text-[#555555] text-2xl text-center" >
							Temukan partner profesional untuk kebersihan, servis elektronik, hingga laundry yang telah terverifikasi oleh komunitas anak kos.
						</span>
					</div>
					<div class="flex flex-col items-center self-stretch mb-[68px]">
						<div class="flex items-center bg-white px-[9px] rounded-xl border border-solid border-[#C3C5D9]" style="box-shadow: 0px 1px 2px #0000000D">
							<img
								src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/vnf1k5p3_expires_30_days.png" 
								class="w-[34px] h-[18px] mr-4 rounded-xl object-fill"
							/>
							<input
								type="text"
								placeholder="Cari nama mitra atau jenis layanan..."
								class="text-gray-500 bg-transparent text-base w-[574px] py-[23px] mr-1 border-0"
							/>
							<div class="flex flex-col shrink-0 items-start bg-[#1E8593] py-[11px] px-8 rounded-xl">
								<span class="text-white text-xs" >
									Cari Mitra
								</span>
							</div>
						</div>
					</div>
					<div class="mx-auto flex w-full max-w-[1216px] flex-col gap-12 px-6 pb-[307px]">
						@yield('content')
					</div>
				</div>
				<div class="flex flex-col items-center bg-white absolute bottom-[-198px] left-[104px] py-4 px-6 rounded-[32px]">
					<div class="flex flex-col items-center mb-12">
						<div class="flex flex-col items-start px-[377px]">
							<span class="text-[#191C1E] text-[32px] font-bold" >
								Kenapa Pesan Lewat Kosera?
							</span>
						</div>
						<div class="flex flex-col items-start px-[323px]">
							<span class="text-[#434656] text-base" >
								Kualitas mitra kami adalah prioritas utama untuk kenyamanan kosmu.
							</span>
						</div>
					</div>
					<div class="flex items-center mb-4">
						<button class="flex flex-col shrink-0 items-start bg-[#FFFFFF00] text-left py-[19px] px-[22px] mr-[294px] rounded-xl border-0" style="box-shadow: 0px 2px 4px #0000001A"
							onclick="alert('Pressed!')"}>
							<img
								src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/3xxn52hx_expires_30_days.png" 
								class="w-5 h-[25px] rounded-xl object-fill"
							/>
						</button>
						<button class="flex flex-col shrink-0 items-start bg-[#FFFFFF00] text-left py-[22px] px-[18px] mr-[293px] rounded-xl border-0" style="box-shadow: 0px 2px 4px #0000001A"
							onclick="alert('Pressed!')"}>
							<img
								src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/n64e68f9_expires_30_days.png" 
								class="w-[27px] h-5 rounded-xl object-fill"
							/>
						</button>
						<button class="flex flex-col shrink-0 items-start bg-[#FFFFFF00] text-left p-[19px] rounded-xl border-0" style="box-shadow: 0px 2px 4px #0000001A"
							onclick="alert('Pressed!')"}>
							<img
								src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/u4jrhkkh_expires_30_days.png" 
								class="w-[26px] h-[25px] rounded-xl object-fill"
							/>
						</button>
					</div>
					<div class="flex items-center">
						<div class="flex flex-col shrink-0 items-center pb-2 mr-[184px]">
							<div class="flex flex-col items-center">
								<span class="text-[#191C1E] text-xl font-bold" >
									Mitra Terverifikasi
								</span>
							</div>
						</div>
						<div class="flex flex-col shrink-0 items-center pb-2 mr-[189px]">
							<div class="flex flex-col items-center">
								<span class="text-[#191C1E] text-xl font-bold" >
									Harga Transparan
								</span>
							</div>
						</div>
						<div class="flex flex-col shrink-0 items-center pb-2">
							<div class="flex flex-col items-center">
								<span class="text-[#191C1E] text-xl font-bold" >
									Jaminan Kualitas
								</span>
							</div>
						</div>
					</div>
					<div class="flex items-start">
						<div class="flex flex-col shrink-0 items-center mr-12">
							<span class="text-[#434656] text-base text-center w-[306px]" >
								Semua mitra telah melewati seleksi ketat<br/>dan pengecekan latar belakang.
							</span>
						</div>
						<div class="flex flex-col shrink-0 items-start px-[29px] mr-[50px]">
							<span class="text-[#434656] text-base text-center w-[247px]" >
								Harga sudah disesuaikan dengan<br/>kantong mahasiswa tanpa biaya<br/>tersembunyi.
							</span>
						</div>
						<div class="flex flex-col shrink-0 items-start px-1">
							<span class="text-[#434656] text-base text-center w-[297px]" >
								Tidak puas dengan hasil kerja mitra?<br/>Kami berikan jaminan pengerjaan ulang.
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>


Edit Screen
