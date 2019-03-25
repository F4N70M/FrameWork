<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{% block title %}{% endblock %}</title>

    {% block headCSS %}{% endblock %}
    {% block headJS %}{% endblock %}
</head>
<body>
    {% block header %}
        {% include header.tpl %}
    {% endblock %}

    {% block content %}{% endblock %}

    {% block footer %}
        {% include header.tpl %}
        {% block footerCSS %}{% endblock %}
        {% block footerJS %}{% endblock %}
    {% endblock %}
</body>
</html>