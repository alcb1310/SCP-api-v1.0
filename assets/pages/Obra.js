import React, { useState, useEffect } from "react";
import { Col, Row, Table, Button } from "reactstrap";
import axios from "axios";
import { faCheck, faXmark } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import ObraForm from "../components/ObraForm";

function Obra() {
  const [obras, setObras] = useState([]);
  const [showForm, setShowForm] = useState(false);
  const [isEdit, setIsEdit] = useState(true);
  const [loadObras, setLoadObras] = useState(false);
  const [selectedObra, setSelectedObra] = useState({});

  useEffect(() => {
    axios.get("/api/obras").then((d) => setObras(d.data["hydra:member"]));
  }, [loadObras]);

  const obrasEl = obras.map((obra) => {
    const icon = obra.activo ? faCheck : faXmark;
    return (
      <tr key={obra["@id"]} onClick={() => handleClick(obra["@id"])}>
        <td>{obra.nombre}</td>
        <td>{obra.casas}</td>
        <td>
          <FontAwesomeIcon icon={icon} />
        </td>
      </tr>
    );
  });

  function handleClick(id) {
    const obra = obras.find((data) => data["@id"] === id);
    setSelectedObra(obra);
    setIsEdit(true);
    setShowForm(true);
  }

  function toggleLoadObras() {
    console.log("toggleLoadObras");
    setLoadObras((prev) => !prev);
  }

  function addObra() {
    setShowForm(true);
    setIsEdit(false);
  }

  function closeForm() {
    setIsEdit(false);
    setShowForm(false);
  }

  function clearObra() {
    setSelectedObra({});
  }

  const obraForm = showForm && (
    <ObraForm
      isEdit={isEdit}
      toggleLoadObras={toggleLoadObras}
      closeForm={closeForm}
      obra={selectedObra}
      clearObra={clearObra}
    />
  );

  return (
    <>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>{obraForm}</Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <h3>Obra</h3>
        </Col>
        <Col md={2}>
          <Button color="primary" outline onClick={addObra}>
            Agregar
          </Button>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <Table hover size="sm">
            <thead>
              <tr>
                <td>Nombre</td>
                <td>Casas</td>
                <td>Activo</td>
              </tr>
            </thead>
            <tbody>{obrasEl}</tbody>
          </Table>
        </Col>
      </Row>
    </>
  );
}

export default Obra;
