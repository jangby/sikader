<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Verifikasi Kode</h2>
        <p class="text-sm text-gray-500 mt-2">
            Kami telah mengirim kode ke: <br>
            <b>{{ Auth::user()->email }}</b> dan <b>{{ Auth::user()->no_hp }}</b>
        </p>
    </div>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded text-sm text-center font-bold">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('events.process_verify', $event->id) }}">
        @csrf

        <div class="grid grid-cols-1 gap-6">
            <div class="bg-blue-50 p-4 rounded border border-blue-200">
                <label class="block font-bold text-blue-800 text-sm mb-1">Kode dari EMAIL</label>
                <input type="text" name="email_code" class="w-full text-center text-2xl font-bold tracking-widest border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" maxlength="6" placeholder="000000" required>
            </div>

            <div class="bg-green-50 p-4 rounded border border-green-200">
                <label class="block font-bold text-green-800 text-sm mb-1">Kode dari WHATSAPP</label>
                <input type="text" name="wa_code" class="w-full text-center text-2xl font-bold tracking-widest border-gray-300 rounded focus:ring-green-500 focus:border-green-500" maxlength="6" placeholder="000000" required>
            </div>
        </div>

        <button type="submit" class="w-full mt-6 bg-gray-900 text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition">
            Verifikasi Sekarang
        </button>
    </form>
</x-guest-layout>