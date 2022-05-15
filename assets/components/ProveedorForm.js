import React, { useState, useEffect } from "react";
import { v4 as uuidv4 } from "uuid";
import { Col, Form, FormFeedback, Input, Label, Row, Button } from "reactstrap";
import axios from "axios";

function ProveedorForm(props) {
  const [proveedor, setProveedor] = useState({
    ruc: "",
    nombre: "",
    contacto: "",
    telefono: "",
    email: "",
  });
  const [errorMessage, setErrorMessage] = useState({
    ruc: "",
    nombre: "",
  });

  useEffect(() => {
    if (props.selectedProveedor["@id"]) {
      setProveedor(props.selectedProveedor);
    }
  }, []);

  function handleChange(event) {
    const { name, value } = event.target;

    setProveedor((prevProveedor) => ({
      ...prevProveedor,
      [name]: name === "email" ? value : value.toUpperCase(),
    }));
  }

  function saveProveedor(event) {
    event.preventDefault();
    setErrorMessage({
      ruc: "",
      nombre: "",
    });

    if (props.isEdit) {
      axios
        .put(proveedor["@id"], proveedor)
        .then((d) => {
          props.toggleLoadProveedor();
          props.closeForm();
        })
        .catch((error) => {
          const { violations } = error.response.data;

          for (let i = 0; i < violations.length; i++) {
            const data = violations[i];
            setErrorMessage((prev) => ({
              ...prev,
              [data.propertyPath]: data.message,
            }));
          }
        });
    } else {
      const uuid = uuidv4();
      const data = { ...proveedor, uuid };
      axios
        .post("/api/proveedors", data)
        .then((d) => {
          props.toggleLoadProveedor();
          props.closeForm();
        })
        .catch((error) => {
          const { violations } = error.response.data;

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
    <Form onSubmit={saveProveedor}>
      <Row>
        <Col>
          <Label for="ruc">RUC</Label>
          <Input
            type="text"
            name="ruc"
            id="ruc"
            value={proveedor.ruc}
            onChange={handleChange}
            invalid={errorMessage.ruc.length > 0}
          />
          <FormFeedback>{errorMessage.ruc}</FormFeedback>
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="nombre">Nombre</Label>
          <Input
            type="text"
            name="nombre"
            id="nombre"
            value={proveedor.nombre}
            onChange={handleChange}
            invalid={errorMessage.nombre.length > 0}
          />
          <FormFeedback>{errorMessage.nombre}</FormFeedback>
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="contacto">Contacto</Label>
          <Input
            type="text"
            name="contacto"
            id="contacto"
            value={proveedor.contacto}
            onChange={handleChange}
          />
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="telefono">Teléfono</Label>
          <Input
            type="text"
            name="telefono"
            id="telefono"
            value={proveedor.telefono}
            onChange={handleChange}
          />
        </Col>
      </Row>
      <Row>
        <Col>
          <Label for="email">Email</Label>
          <Input
            type="text"
            name="email"
            id="email"
            value={proveedor.email}
            onChange={handleChange}
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

export default ProveedorForm;
