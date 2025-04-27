<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{% block title %} Static Bootstrap v3 {% endblock %}</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" /> -->
  <style>
    a,
    a:hover,
    a:active,
    a:visited,
    a:focus {
      text-decoration: none;
    }

    .dropdown {
      cursor: pointer;
    }

    .disabled {
      cursor: not-allowed;
      pointer-events: none;
    }

    #main-content {
      min-height: calc(100vh - 72px - 40px);
    }

    #main-footer {
      padding: 10px;
      background-color: #232527;
      color: #fff;
      min-height: 40px;
    }
  </style>
</head>

<body>
  <div id="app" class="container-fluid" style="padding-left: 0;padding-right: 0;">
    <div id="main-header">
      {% block header %}
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{app.config.name}}</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              {% for item in app.config.sources%}
              {% if item.status in ['public','protected'] %}
              <li class="{% if vars.class==item.key %}active{% endif %} {% if item.status=='protected' %}disabled{% endif %}"><a href="/{{item.key}}"><i class="{{item.icon}}"></i> {{item.name}} </a></li>
              {% endif %}
              {% endfor %}
              <li><a href="/admin"><i class="glyphicon glyphicon-cog"></i> 设置 </a></li>
            </ul>
          </div><!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->
      </nav>
      {% endblock %}
    </div>
    <div id="main-content">
      {% block content %}

      {% endblock %}
    </div>

    <div id="main-footer">
      {% block footer %}
      &copy; Copyright 2022 by <a href="#">Langnang</a>.
      {% endblock %}
    </div>
    <script src="https://fastly.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    {% block script %}
    {% endblock %}
</body>

</html>