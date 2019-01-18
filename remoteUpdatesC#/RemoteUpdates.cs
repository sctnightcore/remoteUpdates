using System.Collections;
using UnityEngine;
using UnityEngine.Networking;
using UnityEngine.UI;

public class RemoteUpdates : MonoBehaviour
{

    public Transform bot_container;

    public GameObject inventario;
    public GameObject inventario_h, armazem_h;
    public GameObject scrollViwer;
    public GameObject config;
    public InputField hostIP;
    public InputField exHostIP;
    public GameObject exitConfirmation;
    public Toggle usarExterno;

    public string host_address;
    bool configOpen = false;

    public string bot_real_name;

    public Object bot_prefab;
    public string botnames;
    public string[] bots;
    public string[] saved_bots;
    public float time;

    public GameObject console, console_h;
    public InputField consoleCommand;

    public GameObject status;
    public Text status1, status2;

    public string currentUsingStatus = "";

    public string currentScreen = "Inicio";

    private void Start()
    {
        StartCoroutine(GetBots());
        time = 10f;
    }
    private void LateUpdate()
    {
        time -= Time.deltaTime;
        if ( time <= 0 )
        {
            StartCoroutine(GetBots());
            time = 10f;
        }
    }
    private void Update()
    {
        if ( Input.GetKeyDown(KeyCode.Escape) == true )
        {
            if ( currentScreen == "Inicio")
            {
                exitConfirmation.SetActive(true);
                currentScreen = "Sair";
            }
            else if ( currentScreen == "Sair" )
            {
                Application.Quit();
            }
            else if ( currentScreen == "Configuracao" )
            {
                OpenConfig();
            }
            else if ( currentScreen == "Inventario" || currentScreen == "Armazem" )
            {
                FecharInventario();
            }
            else if ( currentScreen == "Console" )
            {
                FecharConsole();
            }
            else if ( currentScreen == "Status" )
            {
                FecharStatus();
            }
        }
    }
    public void FecharConfirmacaoDeSair()
    {
        exitConfirmation.SetActive(false);
        currentScreen = "Inicio";
    }
    IEnumerator GetBots()
    {
        WWWForm form = new WWWForm();
        form.AddField("req_type", "pegabot");
        form.AddField("name", "-");

        if ( PlayerPrefs.GetString("external_use") == "sim")
        {
            host_address = PlayerPrefs.GetString("host_address_external");
        }
        else
        {
            host_address = PlayerPrefs.GetString("host_address");
        }

        UnityWebRequest www = UnityWebRequest.Post(host_address + "/remoteUpdatesPhp/main.php", form);
        yield return www.SendWebRequest();

        if (www.isNetworkError || www.isHttpError)
        {
            Debug.Log(www.error);
        }
        else
        {
            botnames = www.downloadHandler.text;
            bots = botnames.Split('/');
            for (int x = 0; x < bots.Length; x++)
            {
                if (bots[x] != "" )
                {
                    if (!GameObject.Find(bots[x]))
                    {
                        GameObject tempBot = Instantiate(bot_prefab) as GameObject;
                        tempBot.name = bots[x];
                        tempBot.transform.SetParent(bot_container);
                    }
                }
            }
        }
    }
    public void SwitchInventario()
    {
        scrollViwer.GetComponent<ScrollRect>().content = inventario_h.GetComponent<RectTransform>();
        inventario_h.gameObject.SetActive(true);
        armazem_h.gameObject.SetActive(false);
        currentScreen = "Inventario";
    }
    public void SwitchArmazem()
    {
        scrollViwer.GetComponent<ScrollRect>().content = armazem_h.GetComponent<RectTransform>();
        inventario_h.gameObject.SetActive(false);
        armazem_h.gameObject.SetActive(true);
        currentScreen = "Armazem";
    }
    public void FecharInventario()
    {
        scrollViwer.GetComponent<ScrollRect>().content = inventario_h.GetComponent<RectTransform>();
        foreach ( Transform child in inventario_h.transform )
        {
            Destroy(child.gameObject);
        }
        foreach ( Transform child in armazem_h.transform )
        {
            Destroy(child.gameObject);
        }
        inventario.SetActive(false);
        currentScreen = "Inicio";
    }

    public void OpenConfig()
    {
        if (configOpen == true)
        {
            config.SetActive(false);
            configOpen = false;
            currentScreen = "Inicio";
        }
        else
        {
            if (PlayerPrefs.GetString("host_address") == "")
            {
                hostIP.text = "";
            }
            else
            {
                hostIP.text = PlayerPrefs.GetString("host_address");
            }
            if (PlayerPrefs.GetString("host_address_external") == "")
            {
                exHostIP.text = "";
            }
            else
            {
                exHostIP.text = PlayerPrefs.GetString("host_address_external");
            }
            if (PlayerPrefs.GetString("external_use") == "sim")
            {
                usarExterno.isOn = true;
            }
            else
            {
                usarExterno.isOn = false;
            }
            config.SetActive(true);
            configOpen = true;
            currentScreen = "Configuracao";
        }
    }

    public void SaveConfig()
    {
        if ( usarExterno.isOn == true )
        {
            PlayerPrefs.SetString("external_use", "sim");
        }
        else
        {
            PlayerPrefs.SetString("external_use", "nao");
        }
        PlayerPrefs.SetString("host_address_external", exHostIP.text);
        PlayerPrefs.SetString("host_address", hostIP.text);
        PlayerPrefs.Save();
        config.SetActive(false);
        currentScreen = "Inicio";
    }

    public void ContinueConsole(string name)
    {
        console.gameObject.SetActive(true);
        console.GetComponent<ConsoleUpdate>().Botname = name;
    }

    public void FecharConsole()
    {
        foreach ( Transform child in console_h.transform )
        {
            Destroy(child.gameObject);
        }
        console.SetActive(false);
        currentScreen = "Inicio";
    }

    public void FecharStatus()
    {
        status1.text = "";
        status2.text = "";
        status.SetActive(false);
        GameObject.Find(currentUsingStatus).GetComponent<BotSelfUpdate>().statusAberto = false;
        currentScreen = "Inicio";
    }

    public void ResetConfiguration()
    {
        PlayerPrefs.DeleteAll();
    }

    public void ResetDatabase()
    {
        StartCoroutine(DeleteDatabase());
    }

    IEnumerator DeleteDatabase()
    {
        WWWForm form = new WWWForm();
        form.AddField("req_type", "resetDatabase");
        form.AddField("name", "-");

        if (PlayerPrefs.GetString("external_use") == "sim")
        {
            host_address = PlayerPrefs.GetString("host_address_external");
        }
        else
        {
            host_address = PlayerPrefs.GetString("host_address");
        }

        UnityWebRequest www = UnityWebRequest.Post(host_address + "/remoteUpdatesPhp/main.php", form);
        yield return www.SendWebRequest();

        if (www.isNetworkError || www.isHttpError)
        {
            Debug.Log(www.error);
        }

        foreach ( Transform child in bot_container )
        {
            Destroy(child.gameObject);
        }
    }
}
