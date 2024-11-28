<x-package.dropdown :name="$name" :id="$id" :value="$value" :label="$label">
    {{-- <option value="&#10146;" @selected($value=='&#10146;') >&#10146; &nbsp; &nbsp; &nbsp;<span>( Three-d top-lighted right arrowhead )</span></option>
    <option value="&#9830;" @selected(false) >&#9830; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#8902;" @selected(false) >&#8902; &nbsp; &nbsp; &nbsp;<span>( Bold Star )</span></option>
    <option value="&#9733;" @selected(false) >&#9733; &nbsp; &nbsp; &nbsp;<span>( Bold Large Star )</span></option>
    <option value="&#9734;" @selected(false) >&#9734; &nbsp; &nbsp; &nbsp;<span>( Empty start suit )</span></option>
    <option value="&#10025;" @selected(false) >&#10025; &nbsp; &nbsp; &nbsp;<span>( Edgless start suit )</span></option>
    <option value="&#10026;" @selected(false) >&#10026; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10027;" @selected(false) >&#10027; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10028;" @selected(false) >&#10028; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10029;" @selected(true) >&#10029; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10030;" @selected(false) >&#10030; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10031;" @selected(false) >&#10031; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10032;" @selected(false) >&#10032; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10033;" @selected(false) >&#10033; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10034;" @selected(false) >&#10034; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10035;" @selected(false) >&#10035; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10036;" @selected(false) >&#10036; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10037;" @selected(false) >&#10037; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10038;" @selected(false) >&#10038; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10039;" @selected(false) >&#10039; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10040;" @selected(false) >&#10040; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10041;" @selected(false) >&#10041; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10042;" @selected(false) >&#10042; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10043;" @selected(false) >&#10043; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10043;" @selected(false) >&#10043; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10044;" @selected(false) >&#10044; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10045;" @selected(false) >&#10045; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10046;" @selected(false) >&#10046; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10047;" @selected(false) >&#10047; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10048;" @selected(false) >&#10048; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10049;" @selected(false) >&#10049; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option>
    <option value="&#10050;" @selected(false) >&#10050; &nbsp; &nbsp; &nbsp;<span>( Black diamond suit )</span></option> --}}
    {{-- <option value="&#10162;" @selected(false) >&#10162;</option>
    <option value="&#10170;" @selected(false) >&#10170;</option>
    <option value="&#10172;"" @selected(false) >&#10172;</option> --}}
    {{-- <option value="&#8658;" @selected(false) >&#8658; &nbsp; &nbsp; &nbsp;<span>( Right double arrow )</span></option>
    <option value="&#9839;" @selected(false) >&#9839; &nbsp; &nbsp; &nbsp;<span>( Music sharp sign )</span></option> --}}
    {{-- <option value="&#9850;" @selected(false) >&#9850;</option> --}}
    {{-- <option value="&#9851;" @selected(false) >&#9851; &nbsp; &nbsp; &nbsp;<span>( Black universal recycling symbol )</span></option>
    <option value="&#9856;" @selected(false) >&#9856; &nbsp; &nbsp; &nbsp;<span>( Die face )</span></option> --}}
    {{-- <option value="&#9866;" @selected(false) >&#9866;</option> --}}
    {{-- <option value="&#9872;" @selected(false) >&#9872; &nbsp; &nbsp; &nbsp;<span>( White flag )</span></option>
    <option value="&#9873;" @selected(false) >&#9873; &nbsp; &nbsp; &nbsp;<span>( Black flag )</span></option>
    <option value="&#9888;" @selected(false) >&#9888; &nbsp; &nbsp; &nbsp;<span>( Warning sign )</span></option>
    <option value="&#9896;" @selected(false) >&#9896; &nbsp; &nbsp; &nbsp;<span>( Vertical male with stroke sign )</span></option>
    <option value="&#9897;" @selected(false) >&#9897; &nbsp; &nbsp; &nbsp;<span>( Horizontal male with stroke sign )</span></option>
    <option value="&#9986;" @selected(false) >&#9986; &nbsp; &nbsp; &nbsp;<span>( Black scissors )</span></option>
    <option value="&#9998;" @selected(false) >&#9998; &nbsp; &nbsp; &nbsp;<span>( Lower right pencil )</span></option>
    <option value="&#9991;" @selected(false) >&#9991; &nbsp; &nbsp; &nbsp;<span>( Tape drive )</span></option> --}}
    <option value="&#10004;" @selected($value == "✔")>&#10004; &nbsp; &nbsp; &nbsp;</option>
    <option value="&#10006;" @selected($value == "✖") >&#10006; &nbsp; &nbsp; &nbsp;</option>
</x-package.dropdown>