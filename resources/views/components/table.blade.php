<table id="{{ $id }}" {!! $attributes->merge(['class' => "table table-bordered table-striped table-hover w-100"]) !!}>
    @isset($thead)
        <thead>
            {!! $thead !!}
        </thead>
    @endisset
    <tbody>
        {!! $slot ?? '' !!}
    </tbody>
    @isset($tfoot)
        <tfoot>
            {!! $tfoot !!}
        </tfoot>
    @endisset
</table>
