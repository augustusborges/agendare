var $calendar =  $('#clndVisaoAgendaAberta').fullCalendar({
                locale: 'pt-br',
                editable: true,
                navLinks: false, // can click day/week names to navigate views
                eventLimit: true, // allow "more" link when too many events
                
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    //right: 'month,' //month,agendaWeek,agendaDay,listWeek
                },

                loading: function(bool) {
                    $('#loading').toggle(bool);
                },

                events: {
                    url: 'lib/agendalivre.php', 
                    error: function() {
                        $('#script-warning').show();
                    }
                },
                
                dayRender: function (date, cell) {
                    //var today = new Date('2018-02-25T00:00:00');
                    var dia = $.fullCalendar.moment('2018-02-25');
                    if (date === dia) {
                        cell.css("background-color", "red");
                    }
                }
            });

  var $calendarAgendaCliente =  $('#clndAgendaCliente').fullCalendar({
                locale: 'pt-br',
				defaultView: 'agendaDay', //determina a iniciação do calendario month=mes agendaWeek=semana agendaDay=dia
                editable: true,
                navLinks: false, // can click day/week names to navigate views
                eventLimit: true, // allow "more" link when too many events
				height: 700,
                
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay' //month,agendaWeek,agendaDay,listWeek
                },

                loading: function(bool) {
                    $('#loading').toggle(bool);
                },

                events: {
                    url: 'lib/agendacliente.php', //arquivo que lerá os eventos do arquivo.json os inserindo no calendar
                    error: function() {
                        $('#script-warning').show();
                    }
                },
                
                dayRender: function (date, cell) {
                    //var today = new Date('2018-02-25T00:00:00');
                    var dia = $.fullCalendar.moment('2018-03-09');
                    if (date === dia) {
                        cell.css("background-color", "red");
                    }
                }
            });