<!DOCTYPE html>
<html>
<head>
    <title>Laravel Google Translate Example</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Laravel Google Translate Example</h1>
            </div>
            <div class="card-body">
                <!-- Language Selection -->
                <div class="row mb-3">
                    <div class="col-md-2">
                        <strong>Select Language: </strong>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select changeLang">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="fr" {{ session()->get('locale') == 'fr' ? 'selected' : '' }}>French</option>
                            <option value="es" {{ session()->get('locale') == 'es' ? 'selected' : '' }}>Spanish</option>
                            <option value="ar" {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>Arabic</option>
                        </select>
                    </div>
                </div>

                <!-- Translation Form -->
                <form action="{{ route('translateText') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="text" class="form-label">Text to Translate:</label>
                        <textarea id="text" name="text" class="form-control" rows="4">{{ old('text') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Translate</button>
                </form>

                <!-- Display Translations -->
                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if(isset($translations))
                    <div class="mt-3">
                        <h3>Translations:</h3>
                        <ul>
                            @foreach($translations as $lang => $translation)
                                <li><strong>{{ strtoupper($lang) }}:</strong> {{ $translation }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    var url = "{{ route('changeLang') }}";
    $(".changeLang").change(function(){
        window.location.href = url + "?lang=" + $(this).val();
    });
</script>
</html>
