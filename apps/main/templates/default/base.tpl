<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{% block title %}{% endblock %}</title>

    {% block headCss %}{% endblock %}
    {% block headJs %}{% endblock %}
</head>
<body>
    {% block header %}
        <header>
            {% include header.tpl %}
        </header>
    {% endblock %}

    <main>
        {% block content %}{% endblock %}
    </main>

    {% block footer %}
        <footer>
            {% include header.tpl %}
        </footer>
        {% block footerCSS %}{% endblock %}
        {% block footerJS %}{% endblock %}
    {% endblock %}
</body>
</html>