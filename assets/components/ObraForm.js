import axios from "axios";
import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import { Form, Row, Col, Label, Input, Button, FormFeedback } from "reactstrap";

function ObraForm(props) {
  const [obraValue, setObraValue] = useState({
    nombre: "",
    casas: 0,
    activo: false,
  });
  const [errorMessage, setErrorMessage] = useState({
    nombre: "",
    casas: "",
  });

  useEffect(() => {
    if (props.isEdit) {
      setObraValue({
        nombre: props.obra.nombre,
        casas: props.obra.casas,
        activo: props.obra.activo,
      });
    }
  }, []);

  function handleChange(event) {
    const { value, name, type, checked } = event.target;
    setObraValue((prev) => ({
      ...prev,
      [name]:
        type === "checkbox"
          ? checked
          : name === "casas"
          ? parseInt(value)
          : value.toUpperCase(),
    }));
  }

  function handleSubmit(event) {
    event.preventDefault();
    setErrorMessage({ nombre: "", casas: "" });

    if (props.isEdit) {
      axios
        .put(props.obra["@id"], obraValue)
        .then((d) => {
          props.toggleLoadObras();
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
        .post("/api/obras", {
          nombre: obraValue.nombre,
          casas: obraValue.casas,
          activo: obraValue.activo,
        })
        .then((d) => {
          props.toggleLoadObras();
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

  function exitForm(e) {
    e.preventDefault();
    props.closeForm();
  }

  return (
    <Form onSubmit={handleSubmit} className="mb-3">
      <Row>
        <Col>
          <Label for="name">Nombre</Label>
          <Input
            type="text"
            id="nombre"
            name="nombre"
            value={obraValue.nombre}
            onChange={handleChange}
            invalid={errorMessage.nombre.length > 0}
          />
          <FormFeedback>{errorMessage.nombre}</FormFeedback>
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="casas">Casas</Label>
          <Input
            type="text"
            id="casas"
            name="casas"
            value={obraValue.casas}
            onChange={handleChange}
            invalid={errorMessage.casas.length > 0}
          />
          <FormFeedback>{errorMessage.casas}</FormFeedback>
        </Col>
      </Row>
      <Row>
        <Col>
          <Input
            type="checkbox"
            id="activo"
            name="activo"
            checked={obraValue.activo}
            onChange={handleChange}
          />
          <Label for="activo" className="ms-2">
            Activo
          </Label>
        </Col>
      </Row>
      <Row>
        <Col>
          <Button color="primary" outline>
            Grabar
          </Button>
          <Button color="secondary" outline onClick={exitForm} className="ms-2">
            Cerrar
          </Button>
        </Col>
      </Row>
    </Form>
  );
}

ObraForm.propTyes = {
  isEdit: PropTypes.bool.isRequired,
  toggleLoadObras: PropTypes.func.isRequired,
  closeForm: PropTypes.func.isRequired,
  clearObra: PropTypes.func.isRequired,
  obra: PropTypes.shape({
    "@id": PropTypes.string,
    nombre: PropTypes.string,
    casas: PropTypes.number,
    activo: PropTypes.bool,
  }),
};

export default ObraForm;
