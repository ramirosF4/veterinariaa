@extends('layouts.admin')

@section('titulo_pagina', 'Configuración del Sistema')

@section('contenido')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-cogs mr-2"></i> Configuración del Sistema</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Ajustes Generales</h6>
        </div>
        <div class="card-body">
            
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Pestañas (Tabs) -->
                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-toggle="tab" data-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                            <i class="fas fa-building mr-1"></i> General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="horarios-tab" data-toggle="tab" data-target="#horarios" type="button" role="tab" aria-controls="horarios" aria-selected="false">
                            <i class="fas fa-clock mr-1"></i> Horarios
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="notificaciones-tab" data-toggle="tab" data-target="#notificaciones" type="button" role="tab" aria-controls="notificaciones" aria-selected="false">
                            <i class="fas fa-bell mr-1"></i> Notificaciones
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="finanzas-tab" data-toggle="tab" data-target="#finanzas" type="button" role="tab" aria-controls="finanzas" aria-selected="false">
                            <i class="fas fa-coins mr-1"></i> Finanzas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="smtp-tab" data-toggle="tab" data-target="#smtp" type="button" role="tab" aria-controls="smtp" aria-selected="false">
                            <i class="fas fa-envelope mr-1"></i> Correo (SMTP)
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="sistema-tab" data-toggle="tab" data-target="#sistema" type="button" role="tab" aria-controls="sistema" aria-selected="false">
                            <i class="fas fa-desktop mr-1"></i> Sistema
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las Pestañas -->
                <div class="tab-content pt-4" id="settingsTabsContent">
                    
                    <!-- Tab General -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="font-weight-bold text-gray-700">Logotipo de la Veterinaria</label>
                                <div class="d-flex align-items-center">
                                    @if(isset($settings['clinic_logo']) && $settings['clinic_logo'] != '')
                                        <img src="{{ asset('storage/' . $settings['clinic_logo']) }}" alt="Logo" class="img-thumbnail mr-3" style="max-height: 80px;">
                                    @else
                                        <div class="bg-light border rounded text-center d-flex align-items-center justify-content-center mr-3" style="width: 80px; height: 80px;">
                                            <i class="fas fa-image text-muted fa-2x"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <input type="file" class="form-control-file" id="clinic_logo" name="clinic_logo" accept="image/*">
                                        <small class="text-muted d-block mt-1">Formatos recomendados: PNG o JPG. Tamaño ideal: 200x50px.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clinic_name" class="font-weight-bold text-gray-700">Nombre de la Veterinaria</label>
                                    <input type="text" class="form-control" id="clinic_name" name="clinic_name" value="{{ old('clinic_name', $settings['clinic_name'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="clinic_phone" class="font-weight-bold text-gray-700">Teléfono</label>
                                    <input type="text" class="form-control" id="clinic_phone" name="clinic_phone" value="{{ old('clinic_phone', $settings['clinic_phone'] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="clinic_email" class="font-weight-bold text-gray-700">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="clinic_email" name="clinic_email" value="{{ old('clinic_email', $settings['clinic_email'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="clinic_address" class="font-weight-bold text-gray-700">Dirección Física</label>
                                    <input type="text" class="form-control" id="clinic_address" name="clinic_address" value="{{ old('clinic_address', $settings['clinic_address'] ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Horarios -->
                    <div class="tab-pane fade" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-1"></i> Configura los horarios de operación de la clínica. Formato sugerido: 09:00 - 18:00 o "Cerrado".
                        </div>
                        <div class="row">
                            @php
                                $dias = [
                                    'monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles',
                                    'thursday' => 'Jueves', 'friday' => 'Viernes', 'saturday' => 'Sábado', 'sunday' => 'Domingo'
                                ];
                            @endphp
                            
                            @foreach($dias as $key => $dia)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="schedule_{{ $key }}" class="font-weight-bold text-gray-700">{{ $dia }}</label>
                                    <input type="text" class="form-control" id="schedule_{{ $key }}" name="schedule_{{ $key }}" value="{{ old('schedule_'.$key, $settings['schedule_'.$key] ?? '') }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tab Notificaciones -->
                    <div class="tab-pane fade" id="notificaciones" role="tabpanel" aria-labelledby="notificaciones-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold">WhatsApp API (Credenciales)</h6>
                                <p class="text-muted small">Configuración para el envío automático de recordatorios de citas.</p>
                                
                                <div class="form-group">
                                    <label for="whatsapp_api_url" class="font-weight-bold text-gray-700">API URL</label>
                                    <input type="text" class="form-control" id="whatsapp_api_url" name="whatsapp_api_url" value="{{ old('whatsapp_api_url', $settings['whatsapp_api_url'] ?? '') }}" placeholder="https://graph.facebook.com/v19.0/...">
                                </div>
                                <div class="form-group">
                                    <label for="whatsapp_token" class="font-weight-bold text-gray-700">Access Token</label>
                                    <input type="password" class="form-control" id="whatsapp_token" name="whatsapp_token" value="{{ old('whatsapp_token', $settings['whatsapp_token'] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning h-100">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> <strong>Importante:</strong><br><br>
                                    Esta sección se encuentra en preparación para la futura integración de la API de WhatsApp para envío de citas. Al guardar estas credenciales, se almacenarán de forma segura en la base de datos.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Finanzas -->
                    <div class="tab-pane fade" id="finanzas" role="tabpanel" aria-labelledby="finanzas-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency_symbol" class="font-weight-bold text-gray-700">Símbolo de Moneda</label>
                                    <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol'] ?? '$') }}" placeholder="Ej: $, MXN, USD">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax_percentage" class="font-weight-bold text-gray-700">Porcentaje de IVA por defecto (%)</label>
                                    <input type="number" step="0.01" class="form-control" id="tax_percentage" name="tax_percentage" value="{{ old('tax_percentage', $settings['tax_percentage'] ?? '16') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Correo (SMTP) -->
                    <div class="tab-pane fade" id="smtp" role="tabpanel" aria-labelledby="smtp-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_host" class="font-weight-bold text-gray-700">Servidor SMTP (Host)</label>
                                    <input type="text" class="form-control" id="mail_host" name="mail_host" value="{{ old('mail_host', $settings['mail_host'] ?? '') }}" placeholder="Ej: smtp.mailtrap.io">
                                </div>
                                <div class="form-group">
                                    <label for="mail_port" class="font-weight-bold text-gray-700">Puerto</label>
                                    <input type="text" class="form-control" id="mail_port" name="mail_port" value="{{ old('mail_port', $settings['mail_port'] ?? '587') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mail_username" class="font-weight-bold text-gray-700">Usuario</label>
                                    <input type="text" class="form-control" id="mail_username" name="mail_username" value="{{ old('mail_username', $settings['mail_username'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="mail_password" class="font-weight-bold text-gray-700">Contraseña</label>
                                    <input type="password" class="form-control" id="mail_password" name="mail_password" value="{{ old('mail_password', $settings['mail_password'] ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="mail_encryption" class="font-weight-bold text-gray-700">Encriptación</label>
                                    <select class="form-control" id="mail_encryption" name="mail_encryption">
                                        <option value="tls" {{ (old('mail_encryption', $settings['mail_encryption'] ?? '') == 'tls') ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ (old('mail_encryption', $settings['mail_encryption'] ?? '') == 'ssl') ? 'selected' : '' }}>SSL</option>
                                        <option value="" {{ (old('mail_encryption', $settings['mail_encryption'] ?? '') == '') ? 'selected' : '' }}>Ninguna</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Sistema -->
                    <div class="tab-pane fade" id="sistema" role="tabpanel" aria-labelledby="sistema-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pagination_limit" class="font-weight-bold text-gray-700">Registros por página en tablas</label>
                                    <select class="form-control" id="pagination_limit" name="pagination_limit">
                                        <option value="10" {{ (old('pagination_limit', $settings['pagination_limit'] ?? '10') == '10') ? 'selected' : '' }}>10 Registros</option>
                                        <option value="25" {{ (old('pagination_limit', $settings['pagination_limit'] ?? '10') == '25') ? 'selected' : '' }}>25 Registros</option>
                                        <option value="50" {{ (old('pagination_limit', $settings['pagination_limit'] ?? '10') == '50') ? 'selected' : '' }}>50 Registros</option>
                                        <option value="100" {{ (old('pagination_limit', $settings['pagination_limit'] ?? '10') == '100') ? 'selected' : '' }}>100 Registros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch mt-4">
                                        <input type="hidden" name="enable_dark_mode" value="0">
                                        <input type="checkbox" class="custom-control-input" id="enable_dark_mode" name="enable_dark_mode" value="1" {{ (old('enable_dark_mode', $settings['enable_dark_mode'] ?? '0') == '1') ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold text-gray-700" for="enable_dark_mode">Habilitar Modo Oscuro (Futuro)</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <hr>
                
                <div class="text-right">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-1"></i> Guardar Configuración
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
