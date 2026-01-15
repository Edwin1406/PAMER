"use strict";

!function () {
  var e = document.querySelector("div .exito");
  e && setTimeout(function () {
    e.remove();
  }, 3e3);
}(), function () {
  var e = document.querySelector("#maquina_id");

  if (e) {
    var n = [],
        o = [];
    var t = document.querySelector("#listado-maquinas");
    !function _callee() {
      var e, o;
      return regeneratorRuntime.async(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              e = location.origin + "/admin/api/maquinas";
              _context.next = 3;
              return regeneratorRuntime.awrap(fetch(e));

            case 3:
              o = _context.sent;
              _context.next = 6;
              return regeneratorRuntime.awrap(o.json());

            case 6:
              resultado = _context.sent;

              (function () {
                var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
                n = e.map(function (e) {
                  return {
                    nombre: "" + e.nombre.trim(),
                    id: e.id
                  };
                }), console.log(n);
              })(resultado);

            case 8:
            case "end":
              return _context.stop();
          }
        }
      });
    }(), e.addEventListener("input", function (e) {
      var i = e.target.value;

      if (i.length > 3) {
        var _e = new RegExp(i, "i");

        o = n.filter(function (n) {
          if (-1 != n.nombre.toLowerCase().search(_e)) return n;
        });
      } else o = [];

      !function () {
        for (; t.firstChild;) {
          t.removeChild(t.firstChild);
        }

        if (o.length > 0) o.forEach(function (e) {
          var n = document.createElement("LI");
          n.classList.add("listado-maquinas__maquina"), n.textContent = e.nombre, n.dataset.id = e.id, t.appendChild(n);
        });else {
          var _e2 = document.createElement("P");

          _e2.classList.add("listado-maquinas__no-resultado"), _e2.textContent = "No hay resultados", t.appendChild(_e2);
        }
      }();
    });
  }
}(), function () {
  var e = {
    liner_id: "",
    pedido_id: "",
    pedido2_id: "",
    bobinaInterna_id: "",
    bobinaIntermedia_id: "",
    bobinaExterna_id: ""
  },
      n = [],
      o = [];

  function t(e, t) {
    n = e, o = t, console.log("copia de test:" + n), console.log("copia de bobinas:" + o);
  }

  if (document.querySelector(".pedidos")) {
    var i = function i(n) {
      if (("pedido_id" === n.target.name || "pedido2_id" === n.target.name) && _o.value === a.value) return a.value = "", void Swal.fire("Pedido ya seleccionado", "No puede seleccionar el mismo pedido", "error");
      e[n.target.name] = n.target.value.trim(), console.log(e), function _callee2() {
        var n, _e3, _o2, _i;

        return regeneratorRuntime.async(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                n = e.bobinaInterna_id;
                _context2.prev = 1;
                _e3 = "".concat(location.origin, "/admin/api/apibobinas?bobinaInterna_id=").concat(n);
                _context2.next = 5;
                return regeneratorRuntime.awrap(fetch(_e3));

              case 5:
                _o2 = _context2.sent;
                _context2.next = 8;
                return regeneratorRuntime.awrap(_o2.json());

              case 8:
                _i = _context2.sent;
                console.log(_i), t(_i);
                _context2.next = 15;
                break;

              case 12:
                _context2.prev = 12;
                _context2.t0 = _context2["catch"](1);
                console.log(_context2.t0);

              case 15:
              case "end":
                return _context2.stop();
            }
          }
        }, null, null, [[1, 12]]);
      }(), function _callee3() {
        var n, _e4, _o3, _i2;

        return regeneratorRuntime.async(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                n = e.liner_id;
                _context3.prev = 1;
                _e4 = "".concat(location.origin, "/admin/api/test?liner_id=").concat(n);
                _context3.next = 5;
                return regeneratorRuntime.awrap(fetch(_e4));

              case 5:
                _o3 = _context3.sent;
                _context3.next = 8;
                return regeneratorRuntime.awrap(_o3.json());

              case 8:
                _i2 = _context3.sent;
                t(_i2), console.log(_i2);
                _context3.next = 15;
                break;

              case 12:
                _context3.prev = 12;
                _context3.t0 = _context3["catch"](1);
                console.log(_context3.t0);

              case 15:
              case "end":
                return _context3.stop();
            }
          }
        }, null, null, [[1, 12]]);
      }(), function _callee4() {
        var n, _e5, _o4, _t;

        return regeneratorRuntime.async(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                n = e.bobinaExterna_id;
                _context4.prev = 1;
                _e5 = "".concat(location.origin, "/admin/api/apibobina_externa?bobinaExterna_id=").concat(n);
                _context4.next = 5;
                return regeneratorRuntime.awrap(fetch(_e5));

              case 5:
                _o4 = _context4.sent;
                _context4.next = 8;
                return regeneratorRuntime.awrap(_o4.json());

              case 8:
                _t = _context4.sent;
                console.log(_t);
                _context4.next = 15;
                break;

              case 12:
                _context4.prev = 12;
                _context4.t0 = _context4["catch"](1);
                console.log(_context4.t0);

              case 15:
              case "end":
                return _context4.stop();
            }
          }
        }, null, null, [[1, 12]]);
      }(), function _callee5() {
        var n, _e6, _o5, _t2;

        return regeneratorRuntime.async(function _callee5$(_context5) {
          while (1) {
            switch (_context5.prev = _context5.next) {
              case 0:
                n = e.bobinaIntermedia_id;
                _context5.prev = 1;
                _e6 = "".concat(location.origin, "/admin/api/apibobina_media?bobinaIntermedia_id=").concat(n);
                _context5.next = 5;
                return regeneratorRuntime.awrap(fetch(_e6));

              case 5:
                _o5 = _context5.sent;
                _context5.next = 8;
                return regeneratorRuntime.awrap(_o5.json());

              case 8:
                _t2 = _context5.sent;
                console.log(_t2);
                _context5.next = 15;
                break;

              case 12:
                _context5.prev = 12;
                _context5.t0 = _context5["catch"](1);
                console.log(_context5.t0);

              case 15:
              case "end":
                return _context5.stop();
            }
          }
        }, null, null, [[1, 12]]);
      }();
    };

    var _n = document.querySelector('[name="liner_id"]'),
        _o = document.querySelector('[name="pedido_id"]'),
        a = document.querySelector('[name="pedido2_id"]'),
        d = document.querySelector('[name="bobinaInterna_id"]'),
        c = document.querySelector('[name="bobinaIntermedia_id"]'),
        r = document.querySelector('[name="bobinaExterna_id"]');

    _n.addEventListener("change", i), _o.addEventListener("change", i), a.addEventListener("change", i), d.addEventListener("change", i), c.addEventListener("change", i), r.addEventListener("change", i);
  }
}();