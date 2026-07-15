<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório da Demanda #{{ $demand->id }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333333;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-bottom: 2px solid #2B6CB0; /* Cor azul de destaque */
            padding-bottom: 10px;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #2B6CB0;
            margin: 0;
        }
        .header-meta {
            text-align: right;
            font-size: 11px;
            color: #666666;
            vertical-align: bottom;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #2B6CB0;
            background-color: #EBF8FF;
            padding: 6px 10px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-left: 4px solid #2B6CB0;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 6px 10px;
            border: 1px solid #E2E8F0;
            vertical-align: top;
        }
        .bg-light {
            background-color: #F7FAFC;
            font-weight: bold;
            width: 20%;
        }

        .description-box {
            border: 1px solid #E2E8F0;
            padding: 12px;
            background-color: #FAFAFA;
            min-height: 100px;
            margin-bottom: 20px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-priority {
            background-color: #ED8936;
            color: #FFFFFF;
        }
        .badge-status {
            background-color: #4A5568;
            color: #FFFFFF;
        }

        /* Tabela do Histórico */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .history-table th {
            background-color: #edf2f7;
            color: #4a5568;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            font-size: 11px;
            border-bottom: 2px solid #cbd5e0;
        }
        .history-table td {
            padding: 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            vertical-align: middle;
        }
        .status-change {
            font-size: 10px;
            color: #718096;
        }
        .arrow-indicator {
            color: #4a5568;
            font-weight: bold;
            margin: 0 4px;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td>
                <h1 class="header-title">Ficha da Demanda #{{ $demand->id }}</h1>
                <span style="font-size: 12px; color: #4A5568;">Sistema: <strong>{{ $demand->system }}</strong></span>
            </td>
            <td class="header-meta">
                Emitido em: {{ now()->format('d/m/Y H:i') }}<br>
                Abertura: {{ $demand->demand_date->format('d/m/Y') }}
            </td>
        </tr>
    </table>

    <div class="section-title">Informações Gerais</div>
    <table class="info-table">
        <tr>
            <td class="bg-light">Título:</td>
            <td colspan="3"><strong>{{ $demand->title }}</strong></td>
        </tr>
        <tr>
            <td class="bg-light">Solicitante:</td>
            <td>{{ $demand->requester }}</td>
            <td class="bg-light">Responsável:</td>
            <td>{{ $demand->responsible->name ?? 'Não atribuído' }}</td>
        </tr>
        <tr>
            <td class="bg-light">Prioridade:</td>
            <td>
                <span class="badge badge-priority">{{ $demand->priority }}</span>
            </td>
            <td class="bg-light">Status Atual:</td>
            <td>
                <span class="badge badge-status">{{ $demand->status }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Descrição da Solicitação</div>
    <div class="description-box">{!! nl2br(e($demand->description)) !!}</div>

    <div class="section-title">Histórico de Alterações</div>
    @if($demand->histories->isNotEmpty())
        <table class="history-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Data/Hora</th>
                    <th style="width: 15%;">Autor</th>
                    <th style="width: 15%;">Ação / Tipo</th>
                    <th style="width: 35%;">Descrição da Mudança</th>
                    <th style="width: 20%; text-align: right;">Fluxo de Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demand->histories as $history)
                    <tr>
                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                        <td><strong>{{ $history->author_name }}</strong></td>
                        <td>{{ ucfirst($history->type) }}</td>
                        <td>{{ $history->description }}</td>
                        <td style="text-align: right;">
                            @if($history->old_status || $history->new_status)
                                <span class="status-change">
                                    {{ $history->old_status ?? 'N/A' }} 
                                    <span class="arrow-indicator">&rarr;</span> 
                                    <strong>{{ $history->new_status ?? 'N/A' }}</strong>
                                </span>
                            @else
                                <span style="color: #a0aec0; font-size: 10px;">Sem alteração</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color: #718096; font-style: italic; margin-top: 10px;">Nenhum histórico registrado para esta demanda até o momento.</p>
    @endif

</body>
</html>