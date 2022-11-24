<ul class="menu-inner py-1 pb-5">

    {{-- Pusat --}}

    @if ($global->currently_on == 'main')
        <x-menu route="main.dashboard" icon="bx bx-home-circle">Dasbor</x-menu>
        <x-menu route="main.regionals.index" icon="bx bxs-map-alt">Regional</x-menu>

        <x-menu route="main.master.*" icon="bx bxs-data">
            Master Data
            @slot('submenus')
                <x-submenu route="main.master.insurance-types.index">Jenis Jaminan</x-submenu>
                <x-submenu route="main.master.templates.index">Template</x-submenu>
                <x-submenu route="main.master.insurances.index">Asuransi</x-submenu>
                <x-submenu route="main.master.insurance-rates.index">Rate Asuransi</x-submenu>
                <x-submenu route="main.master.banks.index">Bank</x-submenu>
                <x-submenu route="main.master.bank-rates.index">Rate Bank</x-submenu>
                <x-submenu route="main.master.agents.index">Agen</x-submenu>
                <x-submenu route="main.master.agent-rates.index">Rate Agen</x-submenu>
                <x-submenu route="main.master.obligees.index">Obligee</x-submenu>
                <x-submenu route="main.master.principals.index">Principal</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="main.sb-reports.*" icon="bx bxs-file">
            Laporan Surety Bond
            @slot('submenus')
                <x-submenu route="main.sb-reports.product">Produksi</x-submenu>
                <x-submenu route="main.sb-reports.finance">Keuangan</x-submenu>
                <x-submenu route="main.dashboard">Sisa Agen</x-submenu>
                <x-submenu route="main.sb-reports.income">Pemasukan</x-submenu>
                <x-submenu route="main.sb-reports.expense">Pengeluaran</x-submenu>
                <x-submenu route="main.dashboard">Laba</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="main.bg-reports.*" icon="bx bxs-file">
            Laporan Bank Garansi
            @slot('submenus')
                <x-submenu route="main.bg-reports.product">Produksi</x-submenu>
                <x-submenu route="main.bg-reports.finance">Keuangan</x-submenu>
                <x-submenu route="main.dashboard">Sisa Agen</x-submenu>
                <x-submenu route="main.bg-reports.income">Pemasukan</x-submenu>
                <x-submenu route="main.bg-reports.expense">Pengeluaran</x-submenu>
                <x-submenu route="main.dashboard">Laba</x-submenu>
            @endslot
        </x-menu>
    @endif

    {{-- Regional --}}

    @if ($global->currently_on == 'regional')
        <x-menu route="regional.dashboard" :route-params="['regional' => $global->regional->slug]" icon="bx bx-home-circle">Dasbor</x-menu>
        <x-menu route="regional.branches.index" :route-params="['regional' => $global->regional->slug]" icon="bx bx-buildings">Cabang</x-menu>

        <x-menu route="regional.master.*" icon="bx bxs-data">
            Master Data
            @slot('submenus')
                <x-submenu route="regional.master.insurance-types.index" :route-params="['regional' => $global->regional->slug]">Jenis Jaminan</x-submenu>
                <x-submenu route="regional.master.templates.index" :route-params="['regional' => $global->regional->slug]">Template</x-submenu>
                <x-submenu route="regional.master.insurances.index" :route-params="['regional' => $global->regional->slug]">Asuransi</x-submenu>
                <x-submenu route="regional.master.insurance-rates.index" :route-params="['regional' => $global->regional->slug]">Rate Asuransi</x-submenu>
                <x-submenu route="regional.master.banks.index" :route-params="['regional' => $global->regional->slug]">Bank</x-submenu>
                <x-submenu route="regional.master.bank-rates.index" :route-params="['regional' => $global->regional->slug]">Rate Bank</x-submenu>
                <x-submenu route="regional.master.agents.index" :route-params="['regional' => $global->regional->slug]">Agen</x-submenu>
                <x-submenu route="regional.master.agent-rates.index" :route-params="['regional' => $global->regional->slug]">Rate Agen</x-submenu>
                <x-submenu route="regional.master.obligees.index" :route-params="['regional' => $global->regional->slug]">Obligee</x-submenu>
                <x-submenu route="regional.master.principals.index" :route-params="['regional' => $global->regional->slug]">Principal</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="regional.products.*" icon="bx bxs-receipt">
            Produk
            @slot('submenus')
                <x-submenu route="regional.products.surety-bonds.index" :route-params="['regional' => $global->regional->slug]">Surety Bond</x-submenu>
                <x-submenu route="regional.products.guarantee-banks.index" :route-params="['regional' => $global->regional->slug]">Bank Garansi</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="regional.payments.*" icon="bx bxs-wallet">
            Pembayaran
            @slot('submenus')
                <x-submenu route="regional.payments.regional-to-insurance.index" :route-params="['regional' => $global->regional->slug]">Ke Asuransi</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="regional.dashboard" :route-params="['regional' => $global->regional->slug]" icon="bx bx-money">Pengeluaran</x-menu>

        <x-menu route="regional.sb-reports.*" icon="bx bxs-file">
            Laporan Surety Bond
            @slot('submenus')
                <x-submenu route="regional.sb-reports.product" :route-params="['regional' => $global->regional->slug]">Produksi</x-submenu>
                <x-submenu route="regional.sb-reports.finance" :route-params="['regional' => $global->regional->slug]">Keuangan</x-submenu>
                <x-submenu route="regional.dashboard" :route-params="['regional' => $global->regional->slug]">Sisa Agen</x-submenu>
                <x-submenu route="regional.sb-reports.income" :route-params="['regional' => $global->regional->slug]">Pemasukan</x-submenu>
                <x-submenu route="regional.sb-reports.expense" :route-params="['regional' => $global->regional->slug]">Pengeluaran</x-submenu>
                <x-submenu route="regional.dashboard" :route-params="['regional' => $global->regional->slug]">Laba</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="regional.bg-reports.*" icon="bx bxs-file">
            Laporan Bank Garansi
            @slot('submenus')
                <x-submenu route="regional.bg-reports.product" :route-params="['regional' => $global->regional->slug]">Produksi</x-submenu>
                <x-submenu route="regional.bg-reports.finance" :route-params="['regional' => $global->regional->slug]">Keuangan</x-submenu>
                <x-submenu route="regional.dashboard" :route-params="['regional' => $global->regional->slug]">Sisa Agen</x-submenu>
                <x-submenu route="regional.bg-reports.income" :route-params="['regional' => $global->regional->slug]">Pemasukan</x-submenu>
                <x-submenu route="regional.bg-reports.expense" :route-params="['regional' => $global->regional->slug]">Pengeluaran</x-submenu>
                <x-submenu route="regional.dashboard" :route-params="['regional' => $global->regional->slug]">Laba</x-submenu>
            @endslot
        </x-menu>

        @if (auth()->user()->role == 'main')
            <br>
            <x-menu route="main.regionals.index" icon="bx bx-arrow-back">Kembali</x-menu>
        @endif
    @endif

    {{-- Cabang --}}

    @if ($global->currently_on == 'branch')
        <x-menu route="branch.dashboard" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]" icon="bx bx-home-circle">Dasbor</x-menu>

        <x-menu route="branch.master.*" icon="bx bxs-data">
            Master Data
            @slot('submenus')
                <x-submenu route="branch.master.insurance-types.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Jenis Jaminan</x-submenu>
                <x-submenu route="branch.master.templates.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Template</x-submenu>
                <x-submenu route="branch.master.insurances.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Asuransi</x-submenu>
                <x-submenu route="branch.master.insurance-rates.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Rate Asuransi</x-submenu>
                <x-submenu route="branch.master.banks.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Bank</x-submenu>
                <x-submenu route="branch.master.bank-rates.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Rate Bank</x-submenu>
                <x-submenu route="branch.master.agents.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Agen</x-submenu>
                <x-submenu route="branch.master.agent-rates.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Rate Agen</x-submenu>
                <x-submenu route="branch.master.obligees.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Obligee</x-submenu>
                <x-submenu route="branch.master.principals.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Principal</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="branch.products.*" icon="bx bxs-receipt">
            Produk
            @slot('submenus')
                <x-submenu route="branch.products.surety-bonds.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Surety Bond</x-submenu>
                <x-submenu route="branch.products.guarantee-banks.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Bank Garansi</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="branch.payments.*" icon="bx bxs-wallet">
            Pembayaran
            @slot('submenus')
                <x-submenu route="branch.payments.branch-to-regional.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Ke Regional</x-submenu>
                <x-submenu route="branch.payments.branch-to-agent.index" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Ke Agen</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="branch.sb-reports.*" icon="bx bxs-file">
            Laporan Surety Bond
            @slot('submenus')
                <x-submenu route="branch.sb-reports.product" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Produksi</x-submenu>
                <x-submenu route="branch.sb-reports.finance" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Keuangan</x-submenu>
            @endslot
        </x-menu>

        <x-menu route="branch.bg-reports.*" icon="bx bxs-file">
            Laporan Bank Garansi
            @slot('submenus')
                <x-submenu route="branch.bg-reports.product" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Produksi</x-submenu>
                <x-submenu route="branch.bg-reports.finance" :route-params="['regional' => $global->regional->slug, 'branch' => $global->branch->slug]">Keuangan</x-submenu>
            @endslot
        </x-menu>

        @if (auth()->user()->role == 'main' || auth()->user()->role == 'regional')
            <br>
            <x-menu route="regional.branches.index" :route-params="['regional' => $global->regional->slug]" icon="bx bx-arrow-back">Kembali</x-menu>
        @endif
    @endif

</ul>
