//Monta o calendario de disponibilidade dos colaboradores mostrando os dias que os mesmos estão disponiveis
var $calendarioColaborador =  $('#clndDisponibilidadeColaboradores').fullCalendar({
                locale: 'pt-br',
                editable: true,
                navLinks: true, // can click day/week names to navigate views
                eventLimit: true, // allow "more" link when too many events

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month' //month,agendaWeek,agendaDay,listWeek
                },

                loading: function(bool) {
                    $('#loading').toggle(bool);
                },

                events: {
                    url: 'lib/agendalivre.php', //arquivo que lerá os eventos do arquivo.json os inserindo no calendar
                    error: function() {
                        $('#script-warning').show();
                    }
                },

                dayRender: function (date, cell) {
                    var today = new Date();
                    //var dia = $.fullCalendar.moment('2019-05-15');
                    if (date === today) {
                        cell.css("background-color", "red");
                    }
                }
                              });

//Monta o calendário com os agendamentos do cliente logado
var $calendarioCliente =  $('#clndAgendaCliente').fullCalendar({
                locale: 'pt-br',
				defaultView: 'agendaWeek', //determina a iniciação do calendario month=mes agendaWeek=semana agendaDay=dia
                editable: true,
                navLinks: false, // can click day/week names to navigate views
                eventLimit: true, // allow "more" link when too many events
				height: 700,

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaDay' //month,agendaWeek,agendaDay,listWeek
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
                    var dia = $.fullCalendar.moment('2019-05-15');
                    if (date === dia) {
                        cell.css("background-color", "purple");
                    }
                }
                          });
