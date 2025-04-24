<div wire:ignore>
    <select id="bahan" name="state" style="width: 100%">
        <option value=""></option>
        @foreach ($bahans as $item)
        <option value="{{ $item->id }}">{{ $item->nama }}</option>
        @endforeach
    </select>
</div>
@pushOnce('scripts')
<script>
    $( "#bahan" ).select2({
        theme: "dark-adminlte",
        width: 'resolve',
        placeholder: "Pilih Bahan",
        });
    $('#bahan').on('change', function (e) {
    const data = $('#bahan').select2("val");
    @this.call('selectBahan',data)
    // $('#bahan').val(null).trigger('change');
    });
</script>
@endPushOnce