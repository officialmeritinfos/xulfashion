@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')
    @push('js')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/GianlucaChiarani/FontAwesomeBrowser@0.5/src/fabrowser.css" />
        <!-- CodeMirror CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/codemirror.min.css">
        <!-- CodeMirror Theme -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/theme/dracula.min.css">
        <style>
            .CodeMirror {
                height: 100%;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
        </style>
    @endpush

    <div class="mt-3 container-fluid row wallet-chart-area with-exchange" id="statistics">
        <!-- Statistics -->
        <div class="col-xl-12 mb-4 col-lg-12 col-12">
            <div class="card h-auto">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="card-title mb-0">Customization Tab</h5>
                    <h5 class="card-title mb-0">
                        <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}" target="_blank"><i class="ri-eye-line" data-bs-toggle="tooltip" title="Preview Store"></i> </a>
                    </h5>
                </div>

            </div>
        </div>
        <!--/ Statistics -->

        <div class="ui-kit-cards grid mb-24">

            <form class="row g-3" id="processForm" method="post" action="{{route('user.stores.theme.customize.process')}}">
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Text Color</label>
                    <input type="color" class="form-control form-control-lg" id="inputEmail4" name="textColor" value="{{$setting->textColor}}">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Primary Color</label>
                    <input type="color" class="form-control form-control-lg" id="inputEmail4" name="primaryColor" value="{{$setting->primaryColor}}">
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Title Color</label>
                    <input type="color" class="form-control form-control-lg" id="inputEmail4" name="headerTextColor" value="{{$setting->headerTextColor}}">
                </div>

                <div class="col-lg-12 row mb-5 mt-3">
                    <label class="mb-3">Store Perks(Why Shop with {{$store->name}})</label>
                    <div class="storePerk">
                        @if(!empty($setting->perkTitle))
                            @foreach($setting->perkTitle as $index => $perk)

                                <div id="row" class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Perk<sup class="text-danger">*</sup></label>
                                            <input type="text"  name="perk[]" class="form-control" value="{{ $perk }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Perk Icon<sup class="text-danger">*</sup></label>
                                            <input type="text" name="perkIcon[]" class="form-control" value="{!! $setting->perkIcon[$index] !!}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 input-group mb-3 mt-2">
                                        <textarea class="form-control" name="perkContent[]">{{ $setting->perkContent[$index] }}</textarea>
                                        <button class="btn btn-danger" id="DeleteRow" type="button">Delete</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary addStorePerk">Add Store Perk</button>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Working Days</label>
                    <textarea type="text" class="form-control summernote" id="inputAddress2" name="workingDay">{!! $setting->workingDay !!}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Footer Text</label>
                    <textarea type="text" class="form-control summernote" id="inputAddress2" name="footerText">{!! $setting->footerText !!}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Footer Script</label>
                    <textarea type="text" class="form-control" id="footerScript" name="footerScript">{!! $setting->footerScript !!}</textarea>
                </div>
                <div class="col-12">
                    <label for="inputAddress2" class="form-label">Custom CSS</label>
                    <textarea type="text" class="form-control" id="customCss" name="customCss">{!! $setting->customCSS !!}</textarea>
                </div>
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="default-btn submit">Save</button>
                </div>
            </form>
        </div>

    </div>

    @push('js')
        <script type="text/javascript">
            $(".addStorePerk").click(function () {
                newRowAdd =
                    '<div id="row" class="row"> ' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Perk<sup class="text-danger">*</sup></label> <input type="text" class="form-control" placeholder="Free Delivery" name="perk[]"></div></div>' +
                    '<div class="col-lg-6"><div class="form-group"> <label>Perk Icon<sup class="text-danger">*</sup></label> <input type="text" class="form-control" data-fa-browser name="perkIcon[]"></div></div>' +
                    '<div class="col-lg-12 input-group mb-3 mt-2">' +
                    '<textarea type="text" class="form-control"  name="perkContent[]" ></textarea>' +
                    '<button class="btn btn-danger" id="DeleteRow" type="button">Delete</button> ' +
                    ' </div>';

                $('.storePerk').append(newRowAdd);
            });
            $("body").on("click", "#DeleteRow", function () {
                $(this).parents("#row").remove();
            })
        </script>
        <!-- CodeMirror JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/codemirror.min.js"></script>
        <!-- CodeMirror CSS Mode -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/mode/css/css.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/mode/javascript/javascript.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/GianlucaChiarani/FontAwesomeBrowser@0.5/src/fabrowser.js"></script>
        <script>
            fabrowser();
        </script>
        <script>
            // Initialize CodeMirror
            var editor = CodeMirror.fromTextArea(document.getElementById("customCss"), {
                mode: "css",
                theme: "dracula",
                lineNumbers: true,
                lineWrapping: true,
                extraKeys: { "Ctrl-Space": "autocomplete" }, // Enable Ctrl + Space for auto-completion
            });
            editor.setSize(null, "400px");
        </script>
        <script>
            // Initialize CodeMirror
            var editors = CodeMirror.fromTextArea(document.getElementById("footerScript"), {
                mode: "javascript",
                theme: "dracula",
                lineNumbers: true,
                lineWrapping: true,
                extraKeys: { "Ctrl-Space": "autocomplete" }, // Enable Ctrl + Space for auto-completion
            });
            editors.setSize(null, "400px");
        </script>
        <script src="{{asset('requests/dashboard/user/theme.js')}}"></script>
    @endpush
@endsection
