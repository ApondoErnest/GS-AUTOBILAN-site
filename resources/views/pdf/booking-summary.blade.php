@php
    $isEnglish = $locale === 'en';
    $agencyName = $isEnglish ? $booking->agency?->name_en : $booking->agency?->name_fr;
    $agencyAddress = $isEnglish ? $booking->agency?->address_en : $booking->agency?->address_fr;
    $customerMessageLines = preg_split('/\R/', (string) $booking->customer_message) ?: [];
    $requestedServiceLine = collect($customerMessageLines)
        ->first(fn (string $line): bool => str_starts_with($line, 'Prestation:') || str_starts_with($line, 'Service:'));
    $requestedServiceName = filled($requestedServiceLine)
        ? trim(explode(':', $requestedServiceLine, 2)[1] ?? '')
        : null;
    $serviceName = $requestedServiceName ?: ($isEnglish ? $booking->service?->title_en : $booking->service?->title_fr);
    $vehicleLabel = data_get(
        collect(trans('booking.command.step2.categories', [], $locale))->firstWhere('slug', $booking->vehicle_category),
        'label',
    ) ?? ($booking->vehicle_category ?: '-');
    $labels = [
        'title' => $isEnglish ? 'Visit Request Summary' : 'Recapitulatif de la demande',
        'status' => $isEnglish ? 'Pending validation' : 'En attente de validation',
        'reference' => $isEnglish ? 'Reference' : 'Reference',
        'centre' => $isEnglish ? 'Centre' : 'Centre',
        'service' => $isEnglish ? 'Service' : 'Prestation',
        'date' => $isEnglish ? 'Preferred date' : 'Date souhaitee',
        'period' => $isEnglish ? 'Preferred period' : 'Periode souhaitee',
        'vehicle' => $isEnglish ? 'Vehicle category' : 'Type de vehicule',
        'plate' => $isEnglish ? 'Registration' : 'Immatriculation',
        'address' => $isEnglish ? 'Centre address' : 'Adresse du centre',
        'message' => $isEnglish
            ? 'This request is not an automatic appointment confirmation. A GS AUTOBILAN agent will contact you by phone or WhatsApp to confirm the exact visit time.'
            : 'Cette demande ne vaut pas confirmation automatique du rendez-vous. Un agent GS AUTOBILAN vous contactera par telephone ou WhatsApp pour confirmer l heure exacte de passage.',
        'generated' => $isEnglish ? 'Generated on' : 'Genere le',
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: A5 portrait;
            margin: 24px;
        }

        body {
            color: #1f2937;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .shell {
            border: 1px solid #d9e1ec;
            border-radius: 10px;
            padding: 18px;
        }

        .document-header {
            border-collapse: collapse;
            border-spacing: 0;
            margin: 0;
            width: 100%;
        }

        .document-header td {
            border: 0;
            padding: 0;
            vertical-align: middle;
        }

        .centre-heading {
            width: 64%;
        }

        .header-label {
            color: #4b5563;
            display: block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .centre-name {
            color: #062a5c;
            display: block;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.25;
        }

        .logo-cell {
            text-align: right;
            width: 36%;
        }

        .logo-frame {
            display: inline-block;
            text-align: left;
            width: 132px;
        }

        .logo-frame img {
            width: 132px;
        }

        h1 {
            color: #062a5c;
            font-size: 22px;
            line-height: 1.15;
            margin: 8px 0 0;
            text-transform: uppercase;
        }

        .meta {
            background: #fff8dc;
            border: 1px solid #f3c331;
            border-radius: 8px;
            color: #062a5c;
            font-weight: 700;
            margin-top: 14px;
            padding: 10px 12px;
            text-transform: uppercase;
        }

        .reference {
            color: #062a5c;
            font-size: 19px;
            font-weight: 700;
            margin-top: 4px;
        }

        .summary-table {
            border-collapse: separate;
            border-spacing: 0 8px;
            margin-top: 12px;
            width: 100%;
        }

        .summary-table td {
            border: 1px solid #d9e1ec;
            padding: 9px 10px;
            vertical-align: top;
            width: 50%;
        }

        .label {
            color: #4b5563;
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.08em;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .value {
            color: #1f2937;
            font-size: 13px;
            font-weight: 700;
        }

        .note {
            background: #eaf2ff;
            border-radius: 8px;
            color: #1f2937;
            font-weight: 700;
            margin-top: 14px;
            padding: 11px;
        }

        .footer {
            border-top: 1px solid #d9e1ec;
            color: #4b5563;
            font-size: 11px;
            margin-top: 16px;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="shell">
        <table class="document-header">
            <tr>
                <td class="centre-heading">
                    <span class="header-label">{{ $labels['centre'] }}</span>
                    <span class="centre-name">{{ $agencyName }}</span>
                </td>
                <td class="logo-cell">
                    <span class="logo-frame">
                        <img src="{{ public_path('images/site_logo_pdf.png') }}" alt="GS AUTOBILAN">
                    </span>
                </td>
            </tr>
        </table>
        <h1>{{ $labels['title'] }}</h1>

        <div class="meta">
            {{ $labels['status'] }}
            <div class="reference">{{ $booking->reference }}</div>
        </div>

        <table class="summary-table">
            <tr>
                <td>
                    <span class="label">{{ $labels['centre'] }}</span>
                    <span class="value">{{ $agencyName }}</span>
                </td>
                <td>
                    <span class="label">{{ $labels['service'] }}</span>
                    <span class="value">{{ $serviceName }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">{{ $labels['date'] }}</span>
                    <span class="value">{{ $booking->preferred_date?->toDateString() }}</span>
                </td>
                <td>
                    <span class="label">{{ $labels['period'] }}</span>
                    <span class="value">{{ $booking->preferred_time_slot }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">{{ $labels['vehicle'] }}</span>
                    <span class="value">{{ $vehicleLabel }}</span>
                </td>
                <td>
                    <span class="label">{{ $labels['plate'] }}</span>
                    <span class="value">{{ $booking->vehicle_registration }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                    <span class="label">{{ $labels['address'] }}</span>
                    <span class="value">{{ $agencyAddress }}</span>
                </td>
            </tr>
        </table>

        <div class="note">{{ $labels['message'] }}</div>

        <div class="footer">
            {{ $labels['generated'] }} {{ now()->format('Y-m-d H:i') }} - {{ config('app.name') }}
        </div>
    </div>
</body>
</html>
