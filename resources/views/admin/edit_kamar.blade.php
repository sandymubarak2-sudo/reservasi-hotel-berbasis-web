<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kamar - Admin Hotel</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 25px; border-bottom: 3px solid #3498db; padding-bottom: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; color: #34495e; }
        input, select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-update { width: 100%; padding: 12px; background: #3498db; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px; }
        .btn-update:hover { background: #2980b9; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Data Kamar</h2>
        <form action="{{ url('/admin/kamar/edit/'.$kamar->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Kamar</label>
                <input type="text" name="name" value="{{ $kamar->name }}" required>
            </div>
            <div class="form-group">
                <label>Nomor Kamar</label>
                <input type="text" name="number" value="{{ $kamar->number }}" required>
            </div>
            <div class="form-group">
                <label>Tipe Kamar</label>
                <select name="type" required>
                    <!-- Sesuai dengan ENUM di database Sandy -->
                    <option value="One" {{ $kamar->type == 'One' ? 'selected' : '' }}>One</option>
                    <option value="Studio" {{ $kamar->type == 'Studio' ? 'selected' : '' }}>Studio</option>
                    <option value="Two" {{ $kamar->type == 'Two' ? 'selected' : '' }}>Two</option>
                </select>
            </div>
            <div class="form-group">
                <label>Harga per Malam</label>
                <input type="number" name="price" value="{{ $kamar->price }}" required>
            </div>
            <button type="submit" class="btn-update">💾 Update Data Kamar</button>
        </form>
        <a href="{{ url('/admin') }}" class="btn-back">← Batal dan Kembali</a>
    </div>
</body>
</html>