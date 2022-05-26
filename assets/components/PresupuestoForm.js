import axios from "axios";
import React, { useState, useEffect } from "react";
import { v4 as uuidv4 } from "uuid";
import { Form, Row, Col, Label, Input, Button } from "reactstrap";
import PropTypes from "prop-types";

function PresupuestoForm(props) {
  const [presupuesto, setPresupuesto] = useState({
    uuid: "",
    obra: "",
    partida: "",
    cantidad: 0,
    unitario: 0,
    total: 0,
  });
  const [obras, setObras] = useState([]);
  const [partidas, setPartidas] = useState([]);

  useEffect(() => {
    Promise.all([
      axios
        .get("/api/obras", { params: { activo: true } })
        .then((d) => setObras(d.data["hydra:member"])),
      axios
        .get("/api/partidas", { params: { acumula: false, pagination: false } })
        .then((d) => setPartidas(d.data["hydra:member"])),
    ]);
    if (props.selectedPresupuesto["@id"]) {
      setPresupuesto({
        uuid: props.selectedPresupuesto["@id"],
        obra: props.selectedPresupuesto.obra["@id"],
        partida: props.selectedPresupuesto.partida["@id"],
        cantidad: props.selectedPresupuesto.porgascan,
        unitario: props.selectedPresupuesto.porgascost,
        total: props.selectedPresupuesto.porgastot,
      });
    }
  }, []);

  function handleChange(event) {
    const { value, name } = event.target;
    setPresupuesto((prevPresupuesto) => ({
      ...prevPresupuesto,
      [name]:
        name === "cantidad"
          ? parseFloat(value)
          : name === "unitario"
          ? parseFloat(value)
          : value,
      total: parseFloat(
        (name === "cantidad" ? value : prevPresupuesto.cantidad) *
          (name === "unitario" ? value : prevPresupuesto.unitario)
      ),
    }));
  }

  function savePresupuesto(event) {
    event.preventDefault();
    if (props.isEdit) {
      console.log(presupuesto.uuid);
      const data = {
        obra: presupuesto.obra,
        partida: presupuesto.partida,
        porgascan: presupuesto.cantidad,
        porgascost: presupuesto.unitario,
        porgastot: presupuesto.total,
      };

      axios
        .put(presupuesto.uuid, data)
        .then(() => {
          props.toggleLoadPresupuesto();
          props.closeForm();
        })
        .catch((e) => console.error(e));
    } else {
      const uuid = uuidv4();
      const data = {
        uuid,
        obra: presupuesto.obra,
        partida: presupuesto.partida,
        cantini: presupuesto.cantidad,
        costoini: presupuesto.unitario,
        totalini: presupuesto.total,
      };

      axios
        .post("/api/presupuestos", data)
        .then(() => {
          props.toggleLoadPresupuesto();
          props.closeForm();
        })
        .catch((e) => console.error(e));
    }
  }

  const obraOption = obras.map((obra) => {
    return (
      <option key={obra["@id"]} value={obra["@id"]}>
        {obra.nombre}
      </option>
    );
  });

  const partidaOption = partidas.map((partida) => {
    return (
      <option key={partida["@id"]} value={partida["@id"]}>
        {partida.nombre}
      </option>
    );
  });

  return (
    <Form onSubmit={savePresupuesto}>
      <Row>
        <Col>
          <Label for="obra">Obra</Label>
          <Input
            type="select"
            name="obra"
            id="obra"
            value={presupuesto.obra}
            onChange={handleChange}
            disabled={props.isEdit}
          >
            <option value="">--- Seleccione una obra ---</option>
            {obraOption}
          </Input>
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="partida">Partida</Label>
          <Input
            type="select"
            name="partida"
            id="partida"
            value={presupuesto.partida}
            onChange={handleChange}
            disabled={props.isEdit}
          >
            <option value="">--- Seleccione una partida ---</option>
            {partidaOption}
          </Input>
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="cantidad">Cantidad</Label>
          <Input
            type="number"
            name="cantidad"
            id="cantidad"
            value={presupuesto.cantidad}
            onChange={handleChange}
          />
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="unitario">Unitario</Label>
          <Input
            type="number"
            name="unitario"
            id="unitario"
            value={presupuesto.unitario}
            onChange={handleChange}
          />
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="total">Total</Label>
          <Input
            type="text"
            disabled
            name="total"
            id="total"
            value={presupuesto.total}
          />
        </Col>
      </Row>
      <Row>
        <Col>
          <Button color="primary" outline>
            Grabar
          </Button>
          <Button
            color="secondary"
            outline
            onClick={props.closeForm}
            className="ms-2"
          >
            Salir
          </Button>
        </Col>
      </Row>
    </Form>
  );
}

PresupuestoForm.propTypes = {
  isEdit: PropTypes.bool.isRequired,
  closeForm: PropTypes.func.isRequired,
  toggleLoadPresupuesto: PropTypes.func.isRequired,
  selectedPresupuesto: PropTypes.shape({
    ["@id"]: PropTypes.string,
    obra: PropTypes.shape({
      ["@id"]: PropTypes.string,
    }),
    partida: PropTypes.shape({
      ["@id"]: PropTypes.string,
    }),
    porgascan: PropTypes.number,
    porgascost: PropTypes.number,
    porgastot: PropTypes.number,
  }),
};

export default PresupuestoForm;
