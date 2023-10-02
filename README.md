## Installation
Opencart3

Расширения/Установить расширения/Загрузить файл
```
footer_links.ocmod.zip
```
Открыть файл
catalog/view/theme/default/template/common/footer.twig
и изменить
```
{{ menu }}
```
на
```
{{ menu }}{{ links }}
```
