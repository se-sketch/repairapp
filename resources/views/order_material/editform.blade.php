

<div class="form-group">

   <select name="subdivision_id" id="subdivision_id" class="form-control">

        <option value="">{{trans_choice('text.subdivision', 1)}}</option>
        
        @foreach($subdivisions as $subdivision)
        
        <option value="{{$subdivision->id}}" 
            {{old('subdivision_id', $subdivision_id) == $subdivision->id ? 'selected' : ''}}>
            {{$subdivision->name}}
        </option>

        @endforeach
    </select>

    <div id="subdivision_error" style="color: red">{{$errors->first("subdivision")}}</div>
</div>


<div class="form-group">

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">{{__('text.nomenclature')}}</th>
                <th scope="col">{{__('text.qty')}}</th>
                <th>X</th>
            </tr>
        </thead>
      
        <tbody id="doc_tbody">
            @foreach($order->details as $detail)

            <tr id="tr_id_{{$detail->nomenclature->id}}">
                <td>{{$detail->nomenclature->id}}</td>
                <td>{{$detail->nomenclature->name}}</td>
                <td>
                    <input type="number" name="qtys[{{$detail->nomenclature->id}}][qty]" 
                    id="qty_{{$detail->nomenclature->id}}" step="0.001" min="0.001" 
                    required="true" value="{{$detail->qty}}">
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-sm" 
                        onclick="return this.parentNode.parentNode.remove();">
                        X
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div id="qtys_error" style="color: red">{{$errors->first("qtys")}}</div>


    <label for="pickup">{{__('text.choose_nomenclature')}}:</label>
    <input list="nomenclatures" name="pickup" id="pickup">

    <datalist id="nomenclatures">
        @foreach($nomenclatures as $nomenclature)
            <option value="({{$nomenclature->id}}) {{$nomenclature->name}}">
        @endforeach
    </datalist> 

    <button type="button" onclick="nomenclature_changed()">add</button>

</div>

@csrf

<button type="submit" class="btn btn-outline-dark pl-5 pr-5">{{__('text.save')}}</button>

