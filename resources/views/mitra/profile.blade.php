@extends('layouts.mitra')

@section('content')
<section class="space-y-6">
    <h1 class="text-4xl font-semibold text-black">Profil Saya</h1>

    @if (!empty($message))
        <p role="alert" class="rounded-xl border px-4 py-3 text-sm {{ $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
            {{ $message['text'] }}
        </p>
    @endif

    <article class="rounded-[30px] bg-white shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)]">
        <div class="rounded-t-[30px] bg-[#006b9b] p-8"></div>
        <div class="px-8 pb-8">
            <div class="-mt-12 flex flex-wrap items-end justify-between gap-6">
                <div class="flex items-center gap-5">
                    <figure class="h-28 w-28 overflow-hidden rounded-2xl bg-white shadow">
                        @if (!empty($profile['avatar']))
                            <img src="{{ $profile['avatar'] }}" alt="Foto profil" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-4xl text-slate-400">{{ strtoupper(substr($profile['nama'], 0, 1)) }}</div>
                        @endif
                    </figure>
                    <div>
                        <h2 class="text-3xl font-semibold text-black">{{ $profile['nama'] }}</h2>
                        <p class="text-lg text-[#7c838a]">{{ $profile['email'] }}</p>
                        <p class="text-lg text-[#7c838a]">{{ $profile['phone'] ?? '-' }}</p>
                    </div>
                </div>
                <a href="{{ route('mitra.profile.edit') }}" class="rounded-[10px] bg-[#006b9b] px-8 py-3 text-2xl font-bold text-white">Edit</a>
            </div>

            <dl class="mt-8 grid gap-6 md:grid-cols-2">
                <div>
                    <dt class="text-xl font-medium text-[#7c838a]">Kota</dt>
                    <dd class="text-xl text-black">{{ $profile['location'] ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xl font-medium text-[#7c838a]">Status</dt>
                    <dd class="text-xl text-black">{{ ucfirst($profile['status'] ?? 'active') }}</dd>
                </div>
            </dl>
        </div>
    </article>

    <article class="rounded-[30px] bg-white p-8 shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)]">
        <h3 class="text-2xl font-semibold text-black">Deskripsi Diri</h3>
        <p class="mt-3 text-lg text-[#555]">{{ $profile['bio'] ?? 'Belum ada deskripsi.' }}</p>
    </article>
</section>
@endsection
