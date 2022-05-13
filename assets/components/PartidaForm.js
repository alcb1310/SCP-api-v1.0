import axios from "axios";
import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Button, Col, Form, FormFeedback, Input, Label, Row } from "reactstrap";

function PartidaForm(props) {
  const [partidaValue, setPartidaValue] = useState({
    codigo: "",
    nombre: "",
    acumula: false,
    nivel: 1,
    padre: "",
  });
  const [errorMessage, setErrorMessage] = useState({
    codigo: "",
    nombre: "",
  });
  const [partidasPadre, setPartidasPadre] = useState([]);

  useEffect(() => {
    if (props.selectedPartida.codigo) {
      setPartidaValue({
        codigo: props.selectedPartida.codigo,
        nombre: props.selectedPartida.nombre,
        acumula: props.selectedPartida.acumula,
        nivel: props.selectedPartida.nivel,
        padre: props.selectedPartida.padre["@id"],
      });
    }

    axios
      .get("/api/partidas", {
        params: { pagination: false, acumula: true },
      })
      .then((d) => setPartidasPadre(d.data["hydra:member"]));
  }, []);

  function handleChange(event) {
    const { value, name, type, checked } = event.target;
    setPartidaValue((prevPartida) => ({
      ...prevPartida,
      [name]:
        type === "checkbox"
          ? checked
          : name === "nivel"
          ? parseInt(value)
          : name === "padre"
          ? value
          : value.toUpperCase(),
    }));
  }

  const partidasPadreEl = partidasPadre.map((padre) => (
    <option key={padre["@id"]} value={padre["@id"]}>
      {padre.nombre}
    </option>
  ));

  function grabaPartida(event) {
    event.preventDefault();
    setErrorMessage({
      codigo: "",
      nombre: "",
    });

    const data = {
      ...partidaValue,
      padre: partidaValue.padre === "" ? null : partidaValue.padre,
    };
    console.log(data);
    if (props.isEdit) {
      axios
        .put(props.selectedPartida["@id"], data)
        .then((d) => {
          props.toggleLoadPartida();
          props.closeForm();
        })
        .catch((e) => {
          const { violations } = e.response.data;

          for (let i = 0; i < violations.length; i++) {
            const data = violations[i];
            setErrorMessage((prev) => ({
              ...prev,
              [data.propertyPath]: data.message,
            }));
          }
        });
    } else {
      axios
        .post("/api/partidas", data)
        .then((d) => {
          props.toggleLoadPartida();
          props.closeForm();
        })
        .catch((e) => {
          const { violations } = e.response.data;

          for (let i = 0; i < violations.length; i++) {
            const data = violations[i];
            setErrorMessage((prev) => ({
              ...prev,
              [data.propertyPath]: data.message,
            }));
          }
        });
    }
  }

  return (
    <>
      <Form onSubmit={grabaPartida}>
        <Row className="mb-2">
          <Col>
            <Label for="codigo">Código</Label>
            <Input
              type="text"
              id="codigo"
              name="codigo"
              value={partidaValue.codigo}
              onChange={handleChange}
              invalid={errorMessage.codigo.length > 0}
            />
            <FormFeedback>{errorMessage.codigo}</FormFeedback>
          </Col>
        </Row>
        <Row className="mb-2">
          <Col>
            <Label for="nombre">Nombre</Label>
            <Input
              type="text"
              id="nombre"
              name="nombre"
              value={partidaValue.nombre}
              onChange={handleChange}
              invalid={errorMessage.nombre.length > 0}
            />
            <FormFeedback>{errorMessage.nombre}</FormFeedback>
          </Col>
        </Row>
        <Row className="mb-2">
          <Col md={3}>
            <Input
              type="checkbox"
              id="acumula"
              name="acumula"
              checked={partidaValue.acumula}
              onChange={handleChange}
            />
            <Label for="activo" className="ms-2">
              Acumula
            </Label>
          </Col>
          <Col md={1}>
            <Label for="nivel">Nivel</Label>
          </Col>
          <Col md={3}>
            <Input
              type="number"
              id="nivel"
              name="nivel"
              value={partidaValue.nivel}
              onChange={handleChange}
            />
          </Col>
        </Row>
        <Row className="mb-2">
          <Col>
            <Label for="padre">Partida Padre</Label>
            <Input
              type="select"
              id="padre"
              name="padre"
              value={partidaValue.padre}
              onChange={handleChange}
            >
              <option value={""}> --- Escoja una Partida ---</option>
              {partidasPadreEl}
            </Input>
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
    </>
  );
}

PartidaForm.propTypes = {
  isEdit: PropTypes.bool.isRequired,
  toggleLoadPartida: PropTypes.func.isRequired,
  closeForm: PropTypes.func.isRequired,
  selectedPartida: PropTypes.shape({
    '@id' : PropTypes.string,
    codigo: PropTypes.string,
    nombre: PropTypes.string,
    acumula: PropTypes.bool,
    nivel: PropTypes.number,
    padre: PropTypes.string,
  })
}

export default PartidaForm;
