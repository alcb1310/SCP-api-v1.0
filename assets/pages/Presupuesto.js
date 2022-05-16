import axios from "axios";
import React, { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";
import { Row, Col, Table, Button } from "reactstrap";
import PresupuestoForm from "../components/PresupuestoForm";

function Presupuesto() {
  const [presupuestos, setPresupuestos] = useState([]);
  const [maxPages, setMaxPages] = useState(0);
  const [showForm, setShowForm] = useState(false);
  const [isEdit, setIsEdit] = useState(false);
  const [loadPresupesto, setLoadPresupuesto] = useState(false);
  const [selectedPresupuesto, setSelectedPresupuesto] = useState({});
  const [params, setParams] = useState({
    ["obra.activo"]: true,
    ["partida.acumula"]: false,
  });
  const url = "/api/presupuestos";

  useEffect(() => {
    axios.get(url, { params }).then((d) => {
      setPresupuestos(d.data["hydra:member"]);
      if (d.data["hydra:view"] && d.data["hydra:view"]["hydra:last"]) {
        let p = d.data["hydra:view"]["hydra:last"].search("page=");
        let number = d.data["hydra:view"]["hydra:last"].slice(p + 5);
        p = number.indexOf("?");
        if (p === -1) {
          setMaxPages(parseInt(number));
        } else {
          number = number.slice(0, p);
          setMaxPages(parseInt(number));
        }
      }
    });
  }, [params, loadPresupesto]);

  function handlePageClick(event) {
    const pageSelected = event.selected + 1;
    setParams((prevParam) => ({ ...prevParam, page: pageSelected }));
  }

  function closeForm() {
    setIsEdit(false);
    setShowForm(false);
  }

  function addPresupuesto() {
    setShowForm(true);
    setIsEdit(false);
  }

  function editPresupuesto(id) {
    setIsEdit(true);
    setSelectedPresupuesto(
      presupuestos.find((presupuesto) => presupuesto["@id"] === id)
    );
    setShowForm(true);
  }

  function toggleLoadPresupuesto() {
    setLoadPresupuesto((prevLoadPresupuesto) => !prevLoadPresupuesto);
  }

  const presupuestosEl = presupuestos.map((presupuesto) => {
    return (
      <tr
        key={presupuesto["@id"]}
        onClick={() => editPresupuesto(presupuesto["@id"])}
      >
        <td>{presupuesto.obra.nombre}</td>
        <td>{presupuesto.partida.nombre}</td>
        <td style={{ textAlign: "right" }}>
          {presupuesto.rendidocant.toFixed(2)}
        </td>
        <td style={{ textAlign: "right" }}>
          {presupuesto.reniddotot.toFixed(2)}
        </td>
        <td style={{ textAlign: "right" }}>
          {presupuesto.porgascan.toFixed(2)}
        </td>
        <td style={{ textAlign: "right" }}>
          {presupuesto.porgascost.toFixed(2)}
        </td>
        <td style={{ textAlign: "right" }}>
          {presupuesto.porgastot.toFixed(2)}
        </td>
        <td style={{ textAlign: "right" }}>
          {presupuesto.presactu.toFixed(2)}
        </td>
      </tr>
    );
  });

  const presupuestoForm = showForm && (
    <PresupuestoForm
      isEdit={isEdit}
      closeForm={closeForm}
      toggleLoadPresupuesto={toggleLoadPresupuesto}
      selectedPresupuesto={selectedPresupuesto}
    />
  );

  return (
    <>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>{presupuestoForm}</Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <h3>Presupuesto</h3>
        </Col>
        <Col md={2}>
          <Button color="primary" outline onClick={addPresupuesto}>
            Agregar
          </Button>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <ReactPaginate
            pageCount={maxPages}
            breakLabel="..."
            nextLabel=">>"
            onPageChange={handlePageClick}
            pageRangeDisplayed={3}
            previousLabel="<<"
            renderOnZeroPageCount={null}
            containerClassName="pagination pagination-sm"
            pageClassName="page-item"
            pageLinkClassName="page-link"
            previousClassName="page-item"
            nextClassName="page-item"
            previousLinkClassName="page-link"
            nextLinkClassName="page-link"
            activeLinkClassName="active"
            activeClassName="active"
          />
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 1, size: 9 }}>
          <Table hover size="sm">
            <thead>
              <tr>
                <td rowSpan={2} style={{ textAlign: "center" }}>
                  Obra
                </td>
                <td rowSpan={2} style={{ textAlign: "center" }}>
                  Partida
                </td>
                <td colSpan={2} style={{ textAlign: "center" }}>
                  Rendido
                </td>
                <td colSpan={3} style={{ textAlign: "center" }}>
                  Por Gastar
                </td>
                <td rowSpan={2} style={{ textAlign: "center" }}>
                  Presupuesto
                </td>
              </tr>
              <tr>
                <td>Cantidad</td>
                <td>Total</td>
                <td>Cantidad</td>
                <td>Unitario</td>
                <td>Total</td>
              </tr>
            </thead>
            <tbody>{presupuestosEl}</tbody>
          </Table>
        </Col>
      </Row>
    </>
  );
}

export default Presupuesto;
