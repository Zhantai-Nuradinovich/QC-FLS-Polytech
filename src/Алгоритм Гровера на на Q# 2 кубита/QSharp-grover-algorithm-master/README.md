# Установка и запуск программы
[*Другие варианты установки*](https://docs.microsoft.com/en-us/quantum/install-guide/)

## Предварительные требования
* [Код VS](https://code.visualstudio.com/download)
* [Пакет SDK для .NET Core 3,1 или более поздней версии](https://dotnet.microsoft.com/download) Установить в ту же папку что и Код VS.
* [Установите расширение VS Code](https://marketplace.visualstudio.com/items?itemName=quantum.quantum-devkit-vscode)

## Порядок усановки и запуска
1. Установите шаблоны проектов Quantum.
* Choose View -> Command Palette .
* Choice Q #: Installing Project Templates
Теперь Quantum Development Kit установлен и готов к использованию в ваших приложениях и библиотеках.
2. Создайте новый проект:
* Choose View -> Command Palette .
* Select Q #: create a new project
Выберите автономное консольное приложение.
Перейдите в расположение файловой системы, в котором необходимо создать приложение.
После создания проекта нажмите кнопку Open new project... (Открыть новый проект...).
Если вы еще не установили C# расширение для VS Code, появится всплывающее окно. Установите расширение.
3. Запуск приложения:
* Открыть приложение через командную строку.
* Ввести dotnet run.

**Примечание** 
Сейчас рабочие области с несколькими корневыми папками не поддерживаются в расширении Visual Studio Code. Если в одной рабочей области VS Code несколько проектов, все проекты нужно разместить в одной корневой папке.
