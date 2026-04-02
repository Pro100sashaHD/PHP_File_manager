<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менеджер файлов</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.24.15/antd.min.css" />
    <style>
        .layout-sider { background: #001529; }
        .logo { 
            height: 32px; margin: 16px; 
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 6px; color: white; 
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; letter-spacing: 1px;
        }
        .header { 
            background: #fff; padding: 0 24px; 
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 1px 4px rgba(0,21,41,.08);
        }
        .content-card { 
            background: #fff; padding: 24px; 
            border-radius: 8px; min-height: 280px; 
        }
        /* Стили для имитации настоящей таблицы Ant Design */
        .custom-table { width: 100%; border-spacing: 0; }
        .custom-table th { background: #fafafa; padding: 16px; border-bottom: 1px solid #f0f0f0; text-align: left; font-weight: 500; }
        .custom-table td { padding: 16px; border-bottom: 1px solid #f0f0f0; }
        .custom-table tr:hover { background: #fafafa; }
    </style>
</head>
<body>
    <div class="ant-layout ant-layout-has-sider" style="min-height: 100vh;">
        <section class="ant-layout">
            <header class="ant-layout-header header">
                <h3 style="margin: 0;">Менеджер файлов</h3>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <span class="ant-typography">
                        <span class="ant-badge ant-badge-status ant-badge-status-success"></span>
                        <strong>{{ Auth::user()->name }}</strong> 
                    </span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="ant-btn ant-btn-danger ant-btn-sm ant-btn-background-ghost">
                            Выйти
                        </button>
                    </form>
                </div>
            </header>
            
            <main class="ant-layout-content" style="margin: 24px; overflow: initial;">
                <div class="content-card">
                    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            @if(Auth::user()->role !== 'admin')
                                <form action="/files/upload" method="POST" enctype="multipart/form-data" id="uploadForm">
                                    @csrf
                                    <input type="file" name="file" id="fileInput" onchange="this.form.submit()" style="display:none">
                                    <button type="button" class="ant-btn ant-btn-primary ant-btn-lg" onclick="document.getElementById('fileInput').click()">
                                        <span role="img" aria-label="upload" class="anticon anticon-upload"></span>
                                        Загрузить файл
                                    </button>
                                </form>
                            @endif
                        </div>
                        <span style="color: #8c8c8c;">Всего файлов: {{ count($files) }}</span>
                    </div>
                    
                    <div class="ant-table-wrapper">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Имя файла</th>
                                    @if(Auth::user()->role === 'admin') <th>Владелец</th> @endif
                                    <th>Размер</th>
                                    <th style="text-align: right;">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        <span style="color: #1890ff; margin-right: 8px;">📄</span>
                                        {{ $file->name }}
                                    </td>
                                    @if(Auth::user()->role === 'admin') 
                                        <td><span class="ant-tag ant-tag-blue">{{ $file->user->name }}</span></td> 
                                    @endif
                                    <td style="color: #8c8c8c;">{{ round($file->size / 1024, 2) }} KB</td>
                                    <td style="text-align: right;">
                                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                            <a href="{{ route('files.download', $file->id) }}" class="ant-btn ant-btn-link ant-btn-sm">Скачать</a>

                                            <form action="{{ route('files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ant-btn ant-btn-link ant-btn-sm ant-btn-danger">
                                                    Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </section>
    </div>
</body>
</html>