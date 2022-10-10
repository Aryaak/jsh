<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute harus dapat diterima.',
    'accepted_if' => ':attribute harus dapat diterima saat :other berisi :value.',
    'active_url' => ':attribute bukan merupakan URL yang valid.',
    'after' => ':attribute harus merupakan tanggal setelah :date.',
    'after_or_equal' => ':attribute harus merupakan tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute harus berupa huruf.',
    'alpha_dash' => ':attribute harus berupa huruf, angka, strip dan garis bawah.',
    'alpha_num' => ':attribute harus berupa huruf dan angka.',
    'array' => ':attribute harus berupa daftar.',
    'before' => ':attribute harus merupakan tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus merupakan tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki antara :min sampai :max item.',
        'file' => ':attribute harus berukuran :min sampai :max kilobyte.',
        'numeric' => ':attribute harus berisi antara :min sampai :max.',
        'string' => ':attribute harus berisi antara :min sampai :max karakter.',
    ],
    'boolean' => ':attribute harus merupakan true atau false.',
    'confirmed' => 'Konfirmasi :attribute tidak sesuai.',
    'current_password' => 'Kata sandi tidak sesuai.',
    'date' => ':attribute bukan merupakan tanggal yang valid.',
    'date_equals' => ':attribute harus merupakan tanggal :date.',
    'date_format' => ':attribute tidak sesuai dengan format berikut: :format.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak saat :other berisi :value.',
    'different' => ':attribute dan :other tidak boleh sama.',
    'digits' => ':attribute harus berisi :digits angka.',
    'digits_between' => ':attribute harus memiliki antara :min sampai :max angka.',
    'dimensions' => 'Dimensi :attribute tidak sesuai.',
    'distinct' => 'Ada bidang dengan isi yang sama dengan bidang :attribute.',
    'email' => ':attribute harus merupakan alamat email yang valid.',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => ':attribute yang dipilih tidak valid.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => ':attribute harus merupakan file.',
    'filled' => ':attribute harus diisi.',
    'gt' => [
        'array' => ':attribute harus punya lebih dari :value item.',
        'file' => ':attribute harus berukuran lebih dari :value kilobyte.',
        'numeric' => ':attribute harus berisi lebih dari :value.',
        'string' => ':attribute harus berisi lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus punya lebih dari atau sama dengan :value item.',
        'file' => ':attribute harus berukuran lebih dari atau sama dengan :value kilobyte.',
        'numeric' => ':attribute harus berisi lebih dari atau sama dengan :value.',
        'string' => ':attribute harus berisi lebih dari atau sama dengan :value karakter.',
    ],
    'image' => ':attribute harus merupakan gambar.',
    'in' => 'Pilihan :attribute tidak valid.',
    'in_array' => 'Pilihan :attribute tidak berada di :other.',
    'integer' => ':attribute harus merupakan integer.',
    'ip' => ':attribute harus merupakan alamat IP yang valid.',
    'ipv4' => ':attribute harus merupakan alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus merupakan alamat IPv6 yang valid.',
    'json' => ':attribute harus merupakan JSON string yang valid.',
    'lt' => [
        'array' => ':attribute harus punya kurang dari :value item.',
        'file' => ':attribute harus berukuran kurang dari :value kilobyte.',
        'numeric' => ':attribute harus berisi kurang dari :value.',
        'string' => ':attribute harus berisi kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute harus punya kurang dari atau sama dengan :value item.',
        'file' => ':attribute harus berukuran kurang dari atau sama dengan :value kilobyte.',
        'numeric' => ':attribute harus berisi kurang dari atau sama dengan :value.',
        'string' => ':attribute harus berisi kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => ':attribute harus merupakan alaman MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :max item.',
        'file' => ':attribute tidak boleh berukuran lebih dari :max kilobyte.',
        'numeric' => ':attribute tidak boleh berisi lebih dari :max.',
        'string' => ':attribute tidak boleh berisi lebih dari :max karakter.',
    ],
    'mimes' => ':attribute harus berekstensi: :values.',
    'mimetypes' => ':attribute harus berekstensi: :values.',
    'min' => [
        'array' => ':attribute harus setidaknya memiliki :min item.',
        'file' => ':attribute harus setidaknya berukuran :min kilobyte.',
        'numeric' => ':attribute harus setidaknya berisi :min.',
        'string' => ':attribute harus setidaknya berisi :min karakter.',
    ],
    'multiple_of' => ':attribute harus merupakan gandaan dari :value.',
    'not_in' => 'Pilihan :attribute tidak valid.',
    'not_regex' => 'Format :attribute tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus berisi setidaknya satu huruf.',
        'mixed' => ':attribute harus berisi setidaknya satu huruf besar dan satu huruf kecil.',
        'numbers' => ':attribute harus berisi setidaknya satu angka.',
        'symbols' => ':attribute harus berisi setidaknya satu simbol.',
        'uncompromised' => ':attribute tersebut merupakan :attribute yang mudah diretas. Silakan isi dengan :attribute yang lain.',
    ],
    'present' => 'Bidang :attribute harus ada.',
    'prohibited' => ':attribute tidak boleh diisi.',
    'prohibited_if' => ':attribute tidak boleh diisi saat :other berisi :value.',
    'prohibited_unless' => ':attribute tidak boleh diisi kecuali :other berisi :values.',
    'prohibits' => 'Adanya :attribute melarang adanya :other.',
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus diisi dengan isian berikut: :values.',
    'required_if' => ':attribute wajib diisi saat :other berisi :value.',
    'required_unless' => ':attribute wajib diisi kecuali saat :other berisi :values.',
    'required_with' => ':attribute wajib diisi saat :values ada.',
    'required_with_all' => ':attribute wajib diisi saat :values ada.',
    'required_without' => ':attribute wajib diisi saat :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi sat salah satu dari :values ada.',
    'same' => ':attribute dan :other harus sama.',
    'size' => [
        'array' => ':attribute harus berisi :size item.',
        'file' => ':attribute harus berukuran :size kilobyte.',
        'numeric' => ':attribute harus berisi :size.',
        'string' => ':attribute harus berisi :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari: :values.',
    'string' => ':attribute harus merupakan string.',
    'timezone' => ':attribute harus merupakan timezone yang valid.',
    'unique' => ':attribute yang Anda pilih telah terdaftar.',
    'uploaded' => 'Gagal mengunggah :attribute.',
    'url' => ':attribute harus merupakan URL yang valid.',
    'uuid' => ':attribute harus merupakan UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
