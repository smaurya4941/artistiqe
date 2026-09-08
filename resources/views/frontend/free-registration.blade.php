@if(session('success'))
    <div style="background:#d1fae5; color:#065f46; padding:10px; margin-bottom:10px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#fee2e2; color:#991b1b; padding:10px; margin-bottom:10px;">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:10px; margin-bottom:10px;">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div style="background:#d1fae5; color:#065f46; padding:10px; border-radius:8px; margin-bottom:15px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:10px; border-radius:8px; margin-bottom:15px;">
        <ul style="margin:0; padding-left:15px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<style>
    .free-registration-form {
        max-width: 720px;
        margin: 24px auto;
        padding: 24px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial, "Apple Color Emoji", "Segoe UI Emoji";
        color: #111827;
    }

    .free-registration-form *,
    .free-registration-form *::before,
    .free-registration-form *::after {
        box-sizing: border-box;
    }

    .free-registration-form fieldset {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
        margin: 0 0 18px 0;
    }

    .free-registration-form legend {
        padding: 0 8px;
        font-weight: 600;
        color: #111827;
    }

    .free-registration-form label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 6px 16px 10px 0;
        font-size: 14px;
        color: #374151;
        cursor: pointer;
    }

    .free-registration-form input[type="radio"] {
        accent-color: #111827;
        cursor: pointer;
    }

    .free-registration-form input[type="text"],
    .free-registration-form input[type="number"],
    .free-registration-form input[type="file"],
    .free-registration-form textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
        color: #111827;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        margin: 8px 0 12px 0;
        font-size: 15px;
    }

    .free-registration-form input[type="text"]:focus,
    .free-registration-form input[type="number"]:focus,
    .free-registration-form input[type="file"]:focus,
    .free-registration-form textarea:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }

    .free-registration-form textarea {
        min-height: 110px;
        resize: vertical;
    }

    .free-registration-form button[type="submit"] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border: 1px solid #111827;
        background: #111827;
        color: #ffffff;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.2px;
        cursor: pointer;
        transition: transform 0.06s ease, box-shadow 0.2s ease, background 0.2s ease;
        box-shadow: 0 2px 0 #111827;
    }

    .free-registration-form button[type="submit"]:hover {
        background: #0b1220;
        box-shadow: 0 6px 14px rgba(17, 24, 39, 0.18);
    }

    .free-registration-form button[type="submit"]:active {
        transform: translateY(1px);
        box-shadow: 0 1px 0 #111827;
    }

    @media (min-width: 640px) {
        .free-registration-form .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
    }
</style>
<form class="free-registration-form" action="{{ route('free.registration.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Personal Details -->
    <fieldset>
        <legend>Personal Details:</legend>

        <label>
            <input type="radio" name="type" value="artist" required> Artist
        </label>
        <input type="text" name="first_name" placeholder="First Name">
        <input type="text" name="last_name" placeholder="Last Name">

        <br><br>

        <label>
            <input type="radio" name="type" value="gallery"> Gallery
        </label>
        <input type="text" name="gallery_name" placeholder="Gallery Name">
        <input type="text" name="gallery_location" placeholder="Gallery Location">
    </fieldset>

    <!-- Location Details -->
    <fieldset>
        <legend>Location Details:</legend>
        <input type="text" name="country" placeholder="Country">
        <input type="text" name="city" placeholder="City">
        <input type="text" name="state" placeholder="State/Province">
    </fieldset>

    <!-- Painting Details -->
    <fieldset>
        <legend>Painting Details:</legend>
        <label>Upload Item Image:</label>
        <input type="file" name="item_image" accept="image/*" required>

        <input type="text" name="item_title" placeholder="Item Title" required>
        <textarea name="description" placeholder="Description (Tell the story behind the artwork)"></textarea>
        <input type="text" name="short_description" placeholder="Short Description (Size, Medium, Year)">
        <input type="number" step="0.01" name="price" placeholder="Price">

        <label><input type="radio" name="status" value="for_sale" checked> For Sale</label>
        <label><input type="radio" name="status" value="coming_soon"> Coming Soon</label>
        <label><input type="radio" name="status" value="sold"> Sold</label>
        <label><input type="radio" name="status" value="not_available"> Not Available</label>
    </fieldset>

    <button type="submit">Register</button>
</form>
