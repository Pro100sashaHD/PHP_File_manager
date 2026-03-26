<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Project Iris - File Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.24.15/antd.min.css" />
    <style>
        .logo { height: 32px; margin: 16px; background: rgba(255, 255, 255, 0.3); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
        .site-layout-background { background: #fff; }
    </style>
</head>
<body>
    <div id="root">
        <div class="ant-layout ant-layout-has-sider" style="min-height: 100vh;">

            <section class="ant-layout">
                <header class="ant-layout-header site-layout-background" style="padding: 0 16px; display: flex; justify-content: space-between; align-items: center;">
                    <h3>Файлы</h3>
                    <div>
                        <span style="margin-right: 16px;">{{ Auth::user()->name }}</span>
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="ant-btn ant-btn-link">Выйти</button>
                        </form>
                    </div>
                </header>
                
                <main class="ant-layout-content" style="margin: 24px 16px; padding: 24px; background: #fff; min-height: 280px;">
                    @if(Auth::user()->role !== 'admin')
                        <form action="/files/upload" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" id="fileInput" onchange="this.form.submit()" style="display:none">
                            <button type="button" class="ant-btn ant-btn-primary" onclick="document.getElementById('fileInput').click()">
                                + Загрузить файл
                            </button>
                        </form>
                    @endif
                    
                    <div class="ant-table-wrapper">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead class="ant-table-thead">
                                <tr>
                                    <th class="ant-table-cell">Имя</th>
                                    @if(Auth::user()->role === 'admin') <th>Владелец</th> @endif
                                    <th class="ant-table-cell">Размер</th>
                                    <th class="ant-table-cell">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="ant-table-tbody">
                            @foreach($files as $file)
                                <tr class="ant-table-row">
                                    <td class="ant-table-cell">{{ $file->name }}</td>
                                    @if(Auth::user()->role === 'admin') <td>{{ $file->user->name }}</td> @endif
                                    <td class="ant-table-cell">{{ round($file->size / 1024, 2) }} KB</td>
                                    <td class="ant-table-cell">
                                        <div style="display: flex; gap: 8px;">
                                            <a href="{{ route('files.download', $file->id) }}" class="ant-btn ant-btn-link">Скачать</a>

                                            <form action="{{ route('files.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ant-btn ant-btn-link ant-btn-danger" style="color: #ff4d4f;">
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
                </main>
            </section>
        </div>
    </div>
</body>
</html>